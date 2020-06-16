<?php
defined('_JEXEC') or die;

class PlLibHelperEvents
{
    private $db;

    private static $instance;

    public function __construct()
    {
        $this->db = JFactory::getDbo();
    }

    public static function getInstance()
    {
        if ( is_null( self::$instance ) )
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getEvent($eid, $subid)
    {
		$sql = '
				SELECT e.*, MAX(question_id) last_question_id
				FROM #__pl_events e
				LEFT JOIN #__test_results tr ON (tr.test_id = e.id AND tr.subid = '.$subid.')
				WHERE e.id = '.$eid.' 
				GROUP BY e.id
		';	
        
        $this->db->setQuery($sql);

        $event = $this->db->loadObject();

        if (!empty($event->params)) $event->params = json_decode($event->params, true);

        return $event;
    }

    public function getEvents()
    {

        $sql = 'SELECT * FROM #__pl_events WHERE published = 1';

        $this->db->setQuery($sql);

        $events = $this->db->loadObjectList();

        return $events;
    }

    public function getLatestEvents($num = 6, $type = 'trade')
    {

        $joinSql = '';
        $selectSql = '';
        $whereSql = '';

        $user = JFactory::getUser();


        if ($user->id) {
            $maxLevel = $this->getMaxUserOpenLevel($user->id);
            $joinSql = 'LEFT JOIN #__pl_event_stats es ON es.event_id = e.id AND es.user_id = '.$user->id;
            $joinSql .= ' LEFT JOIN #__pl_event_user_status eus ON eus.event_id = e.id AND eus.user_id = '.$user->id;
            $selectSql = ', es.status, eus.status user_status';
            $whereSql = ' AND e.event_group <='.$maxLevel;
        }

        $sql = '
            SELECT e.*'.$selectSql.' 
            FROM #__pl_events e '.$joinSql.' 
            WHERE e.published = 1 AND e.type ="'.$type.'"'.$whereSql.' ORDER BY e.event_group DESC, e.id DESC
        ';

        $this->db->setQuery($sql);

        $events = $this->db->loadObjectList();
        //print_r($events);
        $finished = array();
        $total = array();
        $userEventsStat['winBonuses'] = 0;


        foreach($events as $event) {
            if (!isset($total[$event->event_group])) $total[$event->event_group] = 0;

            $total[$event->event_group]++;

            if (!empty($event->status) && $event->status == 1) {
                if (!isset($finished[$event->event_group])) $finished[$event->event_group] = 0;
                $finished[$event->event_group]++;
                $userEventsStat['winBonuses'] += $event->bonuses;
            }
        }
        $openedEvents = array();
        $maxLevel = max(array_keys($total));
        foreach($total as $key=>$level) {
            if ($key == 0 && $finished && count($total) == 1 && ($total[$key] - $finished[$key] <= 3)) {
                $openedEvents = $this->openLevelEvents(($key + 1), $user->id);
            } else if (
                $key == $maxLevel
                && (!empty($total[$key]) && !empty($finished[$key]))
                && ($total[$key] - $finished[$key] <= 3)
            ) {
                $openedEvents = $this->openLevelEvents(($key + 1), $user->id);
            }

        }

        $userEventsStat['openedEvents'] = count($openedEvents);
        $userEventsStat['totalFinished'] = 0;
        $userEventsStat['spentBonuses'] = 0;
        foreach($openedEvents as $key=>$event) {
            $userEventsStat['spentBonuses'] +=  $event->open_bonus;
        }

        foreach($finished as $levelFinished) $userEventsStat['totalFinished'] += $levelFinished;

        $session = JFactory::getSession();
        //$session->clear('userEventsStat');
        $session->set('userEventsStat', json_encode($userEventsStat));

        return array_merge($events, $openedEvents);
    }

    public function getMaxUserOpenLevel($userId)
    {
        $this->db->setQuery(
            '
                    SELECT MAX(e.event_group)
                    FROM #__pl_event_user_status eus
                    INNER JOIN #__pl_events e ON e.id = eus.event_id
                    WHERE eus.user_id = '.$userId
        );
        return intval($this->db->loadResult());
    }

    public function getNewUserEvent($eventId, $type = 'trade')
    {

        $user = JFactory::getUser();

        if ($user->id) {
            $maxLevel = intval($this->getMaxUserOpenLevel($user->id));
            $sql = '
                    SELECT e.*, es.status
                    FROM #__pl_events e
                    LEFT JOIN #__pl_event_stats es ON es.event_id = e.id AND es.user_id = '.$user->id.'                            
                    WHERE e.published = 1 AND e.type ="trade" AND e.event_group <= '.$maxLevel.' AND e.id != '.$eventId.'
                    AND (es.status IS NULL OR es.status != 1) 
                    ORDER BY RAND()
            ';

            $this->db->setQuery($sql);
            $event = $this->db->loadObject();
            if ($event) return Jroute::_('index.php?option=com_puzzles&view=puzzles&Itemid=1048&id='.$event->id);
        } else {
            $sql = 'SELECT e.* FROM #__pl_events e WHERE e.published = 1 AND e.event_group = 0 AND e.id != '.$eventId.' ORDER BY RAND()';
            $this->db->setQuery($sql);
            $event = $this->db->loadObject();
            if ($event) return Jroute::_('index.php?option=com_puzzles&view=puzzles&Itemid=1048&id='.$event->id);
        }
    }

    public function openLevelEvents($level, $userId)
    {
        $this->db->setQuery('
                      SELECT e.* 
                      FROM #__pl_events e 
                      WHERE e.type = "trade" AND e.published = 1 AND e.event_group = '.$level
        );

        $events = $this->db->loadObjectList();

        $bonusAccount = PlLibHelperUsers::getInstance()->getBonusAccount($userId);

        $openedEvents = array();

        foreach($events as $event) {
            if ($bonusAccount->value > $event->open_bonus) {

                PlLibHelperUsers::getInstance()->changeBonuses($userId, $event->open_bonus, 'cr', 'Открытие загадки');
                $this->openEvent($event->id, $userId);
                $bonusAccount->value = $bonusAccount->value - $event->open_bonus;
                $event->user_status = 1;
                $event->opened = 1;
                $openedEvents[] = $event;
            }
        }

        return $openedEvents;
    }

    public function openEvent($eventId, $userId)
    {
        $this->db->setQuery('INSERT IGNORE INTO #__pl_event_user_status (`event_id`,`user_id`,`status`) VALUES ('.$eventId.','.$userId.',1)');
        return $this->db->execute();
    }



    public function setCompletedEvent($eid, $userId, $noBonus = false)
    {
        if (!$userId) return false;
        $event = $this->getEvent($eid, $userId);

        $sql = '
                INSERT INTO #__pl_event_stats (`event_id`,`user_id`, `status`,`completed`) VALUES ('.$eid.','.$userId.',1,'.$this->db->Quote(date('Y-m-d H:i:s')).') ON DUPLICATE KEY UPDATE tries = tries + 1, completed = '.$this->db->Quote(date('Y-m-d H:i:s')).', status = 1   
        ';

        $this->db->setQuery($sql);
        $this->db->execute();

        if ($event->status != 1 && !$noBonus) {
            PlLibHelperCertificates::getInstance()->addCertificate($userId, 0);
        }
        if ($event->status != 1 && $event->bonuses > 0 && !$noBonus) {
            $session = JFactory::getSession();
            $session->set('event_bonus', $event->bonuses);
            PlLibHelperUsers::getInstance()->changeBonuses($userId, $event->bonuses, 'deb','Бонус за правильный ответ' );

        }
        //$this->getLatestEvents();
        return PlLibHelperEvents::getInstance()->getNewUserEvent($eid);
    }

    public function setFailedEvent($eid, $userId)
    {
        if (!$userId) return false;
        $sql = '
                INSERT INTO #__pl_event_stats (`event_id`,`user_id`, `status`) VALUES ('.$eid.','.$userId.',2) ON DUPLICATE KEY UPDATE tries = tries + 1, status = 2
        ';

        $this->db->setQuery($sql);

        if ($this->db->execute()) {
            $event = $this->getEvent($eid, $userId);
            if ($event->penalty >0 && !($event->tries%2)) {
                if ($event->user_id) PlLibHelperUsers::getInstance()->changeBonuses($event->user_id, $event->penalty, 'deb','Начисление за неправильный ответ пользователя');
                PlLibHelperUsers::getInstance()->changeBonuses($userId, $event->penalty, 'cr','Списание за неправильный ответ' );
                return $event->penalty;
            }
            return 0;
        }
    }

    public function getCertificates($userId, $activated = 0)
    {
        $where = '';
        if ($activated) $where = ' AND c.activated = 1';
        $sql = '
                SELECT COUNT(c.id) 
                FROM #__pl_users_certificates c 
                WHERE c.user_id = '.$userId.$where.'
                
        ';

        $this->db->setQuery($sql);

        return $this->db->loadResult();
    }
	
	public function getAnswers($subid) 
	{
		$sql = '
				SELECT COUNT(tr.id)
				FROM #__test_results tr				
				WHERE tr.subid = '.$subid;
		$this->db->setQuery($sql);
		
		$result['total'] = $this->db->loadResult();	
		
		$sql = '
				SELECT COUNT(tr.id)
				FROM #__test_results tr				
				WHERE tr.correct = 1 AND tr.subid = '.$subid;
		$this->db->setQuery($sql);
		$result['correct'] = $this->db->loadResult();	
		return $result;
	}
	
	public function subscribeUser($subid, $userlistId)
	{
		if(!include_once(rtrim(JPATH_ADMINISTRATOR,DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_acymailing'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'helper.php')){
			echo 'This code can not work without the AcyMailing Component';
			return false;
		}
		
		$userClass = acymailing_get('class.subscriber');
		$listsubClass = acymailing_get('class.listsub');
		
		$newSubscription = array();
		$userSubscriptions = $listsubClass->getSubscription($subid);
		foreach($userSubscriptions as $listId=>$subscription) {
			$newList = array();
			$newList['status'] = $subscription->status;
			$newSubscription[$listId] = $newList;			
		}
		
		$newList = array();
		
		$newList['status'] = 1;
		$newSubscription[$userlistId] = $newList;
		$userClass->saveSubscription($subid, $newSubscription);		
	}
	
	public function sendEmail($subid, $mailId)
	{
		$senddate = time();
		$this->db->setQuery('INSERT IGNORE INTO #__acymailing_queue (`subid`,`mailid`,`senddate`,`priority`,`paramqueue`) VALUES ('.$this->db->Quote($subid).','.$this->db->Quote($mailId).','.$this->db->Quote($senddate).',1,"")');
        $this->db->query();
	}
	
	public function checkSubid($subid, $email)
	{
		$this->db->setQuery('SELECT subid FROM #__acymailing_subscriber WHERE subid = '.$this->db->Quote($subid).' AND email = '.$this->db->Quote($email));
		return $this->db->loadResult();
	}


}