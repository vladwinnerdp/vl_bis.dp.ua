<?php

defined('_JEXEC') or die;

use Joomla\Registry\Registry;
use Joomla\Utilities\IpHelper;

class PuzzlesModelPuzzles extends JModelItem
{

	public function getItem($id = null)
	{
        $app = JFactory::getApplication('site');

        // Load state from the request.
        $id = $app->input->getInt('id');

        if (!$id) JError::raiseError(404, JText::_("Page Not Found"));

        $db = $this->getDbo();
        $db->setQuery('
                              SELECT e.*, u.name username 
                              FROM #__pl_events e 
                              LEFT JOIN #__users u ON u.id = e.user_id 
                              WHERE e.id = '.$id);

        $item =  $db->loadObject();

        if ($item->params) $item->params = json_decode($item->params, true);


        PlLibHelperEvents::getInstance()->getLatestEvents();
        
        return $item;
	}

	public function hit($id)
    {
        $user = JFactory::getUser();

        if (!$user->id) return false;

        $db =  JFactory::getDbo();
        $db->setQuery('INSERT IGNORE INTO #__pl_event_stats (`event_id`, `user_id`, `status`, `tries`, `completed`) VALUES ('.$id.','.$user->id.',3,0,0)');
        $db->execute();
    }

    public function getRandomEvent()
    {
        $db =  JFactory::getDbo();
        $db->setQuery('SELECT id FROM #__pl_events WHERE event_group = 0 AND published = 1');
        return $db->loadResult();
    }

}
