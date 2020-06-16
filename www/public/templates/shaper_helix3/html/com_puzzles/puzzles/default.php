<?php                                                                                                   
defined('_JEXEC') or die('Restricted access.');
$app = JFactory::getApplication('site');

$this->subid = $app->input->get('subid',0, 'INT');

if ($this->subid) {
	echo $this->loadTemplate($this->item->puzzle_type);
} else {
	echo $this->loadTemplate('nosubid');	
}
