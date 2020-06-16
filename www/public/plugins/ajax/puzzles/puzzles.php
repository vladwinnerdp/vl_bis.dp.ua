<?php defined('_JEXEC') or die;

// Import library dependencies
jimport('joomla.plugin.plugin');
JLoader::import('pl_lib.library');
class plgAjaxPuzzles extends JPlugin
{

	function onAjaxPuzzles()
	{
		$inputCookie  = JFactory::getApplication()->input->cookie;
		
		$input = JFactory::getApplication()->input;
		
		$session = JFactory::getSession();
		
		$subid = $input->get('subid',0,'INT');
		
		$db = JFactory::getDbo();
		
		$request = $input->getArray();
		if (!empty($request['puzzle'])) {
            foreach($request['puzzle'] as $eventId => $question) {
				$event = PlLibHelperEvents::getInstance()->getEvent($eventId, $subid);		
				$correct = 0;
				if (is_numeric($question['questionId'])) {
					$lastQuestion = count($event->params['questions']) - 1;
					if ($event->params['questions'][$question['questionId']]['right_answer'] == $question['answer']				
					) {
						$correct = 1;
					}
				}
				
				try{
					$db->setQuery('
									INSERT INTO #__test_results 
									(
										`test_id`,
										`question_id`,
										`correct`, 
										`subid`
									) VALUES ('.$eventId.','.$question['questionId'].','.$correct.','.$subid.')');
					$db->execute();
				}catch(Exception $e){
										
				}
				if ($lastQuestion == $question['questionId']) {					
					        if(!include_once(rtrim(JPATH_ADMINISTRATOR,DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_acymailing'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'helper.php')){
								echo 'This code can not work without the AcyMailing Component';
								return false;
							}
					$result = PlLibHelperEvents::getInstance()->getAnswers($subid);
					$mailer = acymailing_get('helper.mailer');
					if ($event->mailid) PlLibHelperEvents::getInstance()->sendEmail($subid, $event->mailid);
					if ($event->listid) PlLibHelperEvents::getInstance()->subscribeUser($subid, $event->listid);

					$mailer->report = true;
					$mailer->trackEmail = true;
					$mailer->forceVersion = 1;
					$mailer->autoAddUser = true;
					$mailer->addParam('total', $result['total']);
					$mailer->addParam('correct', $result['correct']);					
					$mailer->addParam('subid', $subid);					
					$mailer->addParam('testId', $eventId);					
					$mailer->sendOne(59, 'vls@arbooz.org'); 
					return [
						'activate' => true
					];
				}
				
				return [
					'nextQuestion' => true
				];
			}
		}		
	}		
}	

