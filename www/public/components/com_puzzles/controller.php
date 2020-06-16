<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JLoader::import('pl_lib.library');

$my = JFactory::getUser();
/* if(empty($my->id)){
	$usercomp = 'com_users';
	$uri = JFactory::getURI();
	$url = '/login?return='.base64_encode($uri->toString());	
	$app = JFactory::getApplication();
	$app->redirect($url);
	return false;
} */

class PuzzlesController extends JControllerLegacy
{
    public function display($cachable = false, $urlparams = false)
    {

        $id    		= $this->input->getInt('id');
        $vName 		= $this->input->getCmd('view');

        $this->input->set('view', $vName);

        parent::display($cachable);

    }

}