<?php

/**
 * @package         Convert Forms
 * @version         2.0.10 Pro
 * 
 * @author          Tassos Marinos <info@tassos.gr>
 * @link            http://www.tassos.gr
 * @copyright       Copyright © 2018 Tassos Marinos All Rights Reserved
 * @license         GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
*/

defined('_JEXEC') or die('Restricted access');

require_once __DIR__ . '/script.install.helper.php';

class PlgConvertFormsZohoCRMInstallerScript extends PlgConvertFormsZohoCRMInstallerScriptHelper
{
	public $name = 'PLG_CONVERTFORMS_ZOHOCRM';
	public $alias = 'zohocrm';
	public $extension_type = 'plugin';
	public $plugin_folder = 'convertforms';
	public $show_message = false;
}
