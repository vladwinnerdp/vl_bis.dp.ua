<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');


class PuzzlesViewAll extends JViewLegacy
{

	function display($tpl = null)
	{	
		JError::raiseError(404, JText::_("Page Not Found"));
	    // Display the view
		parent::display($tpl);
	}
}
