<?php

defined('_JEXEC') or die('Restricted access');

class BisControllerEvent extends JControllerForm
{
    public function batch($model = null)
    {
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        // Set the model
        $model = $this->getModel('event', '', array());

        // Preset the redirect
        $this->setRedirect(JRoute::_('index.php?option=com_bis&view=events' . $this->getRedirectToListAppend(), false));

        return parent::batch($model);
    }
}