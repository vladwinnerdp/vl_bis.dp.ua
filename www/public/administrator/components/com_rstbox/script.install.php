<?php

/**
 * @package         Engage Box
 * @version         3.4.8 Pro
 * 
 * @author          Tassos Marinos <info@tassos.gr>
 * @link            http://www.tassos.gr
 * @copyright       Copyright © 2018 Tassos Marinos All Rights Reserved
 * @license         GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
*/

defined('_JEXEC') or die;

require_once __DIR__ . '/script.install.helper.php';

class Com_RstBoxInstallerScript extends Com_RstBoxInstallerScriptHelper
{
	public $name = 'RSTBOX';
	public $alias = 'rstbox';
	public $extension_type = 'component';

	public function onAfterInstall()
	{
		if ($this->install_type == "update") 
        {
            $this->fixBoxes();

            // Remove unwanted folders
            $this->deleteFolders(array(
                JPATH_SITE . '/components/com_rstbox',
                JPATH_ADMINISTRATOR . '/components/com_rstbox/helpers/assignments',
                JPATH_ADMINISTRATOR . '/components/com_rstbox/helpers/vendors'
            ));

            // Remove unwanted files
            $this->deleteFiles(array(
                JPATH_SITE . '/media/com_rstbox/js/rstbox.js',
                JPATH_SITE . '/media/com_rstbox/css/rstbox.css'
            ));

            if (version_compare($this->installedVersion, '3.0', 'l'))
            {
                JFactory::getApplication()->enqueueMessage('We are excited to announce the rebranding of your <b>Responsive Scroll Triggered Box</b> to <b>Engage Box</b> <a class="btn btn-success" style="margin-left:10px; position:relative; top:-1px;" href="http://www.tassos.gr/blog/welcome-engage-box" target="_blank">Read More</a>.', 'notice');
            }
        }
	}

    function fixBoxes() {
    	
        $data = $this->fetch("rstbox");

        if (!$data) 
        {
            return;
        }

        foreach ($data as $key => $box)
        {
            // Prepare data
            $object = new stdClass();
            $object->id = $box->id;
            $params = json_decode($box->params);

            if (version_compare($this->installedVersion, '3.2.4', '<=')) 
            {
                // Fix Hide Close-Button option
                if (isset($params->hideclosebutton))
                {
                    $params->closebutton->hide = $params->hideclosebutton;
                    unset($params->hideclosebutton);
                }
            }
           
            $object->params = json_encode($params);
             
            // Update database
            $this->db->updateObject('#__rstbox', $object, 'id');
        }
    }
}
