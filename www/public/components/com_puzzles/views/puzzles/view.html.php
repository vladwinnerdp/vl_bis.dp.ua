<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class PuzzlesViewPuzzles extends JViewLegacy
{
    protected $item;

	function display($tpl = null)
	{
        $this->item = $this->get('Item');

        $model = $this->getModel('puzzles');

        $user = JFactory::getUser();

/*        if ($this->item->event_group > 0 && !$user->id) {
            $eventId = $model->getRandomEvent();
            JFactory::getApplication('site')->redirect(Jroute::_('index.php?option=com_puzzles&view=puzzles&Itemid=1048&id='.$eventId));
            //JError::raiseError(404, JText::_("Page Not Found"));
        }

        if ($user->id) {

            $maxLevel = PlLibHelperEvents::getInstance()->getMaxUserOpenLevel($user->id);

            if ($maxLevel < $this->item->event_group) {}
                JError::raiseError(404, JText::_("Page Not Found"));
        } */

        //$model->hit($this->item->id);

	    // Display the view
		parent::display($tpl);
	}
}
