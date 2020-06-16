<?php

/**
 * @package         Engage Box
 * @version         3.4.8 Pro
 * 
 * @author          Tassos Marinos <info@tassos.gr>
 * @link            http://www.tassos.gr
 * @copyright       Copyright © 2016 Tassos Marinos All Rights Reserved
 * @license         GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
*/

defined('_JEXEC') or die('Restricted access');

require_once __DIR__ . '/script.install.helper.php';

class PlgEngageBoxIFrameInstallerScript extends PlgEngageBoxIFrameInstallerScriptHelper
{
	public $name = 'PLG_ENGAGEBOX_IFRAME';
	public $alias = 'iframe';
	public $extension_type = 'plugin';
	public $plugin_folder = "engagebox";
	public $show_message = false;
}
