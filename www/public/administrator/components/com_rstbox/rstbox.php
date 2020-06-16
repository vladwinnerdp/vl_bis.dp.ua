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

defined('_JEXEC') or die('Restricted access');

// Framework check
if (!@include_once(JPATH_PLUGINS . '/system/nrframework/autoload.php'))
{
	throw new RuntimeException('Novarain Framework is not installed', 500);
}

$app = JFactory::getApplication();

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_rstbox'))
{
	$app->enqueueMessage(JText::_('JERROR_ALERTNOAUTHOR'), 'error');
	return;
}

// System plugin check.
if (!NRFramework\Extension::pluginIsEnabled('rstbox'))
{
	$app->enqueueMessage(JText::_('Engage Box plugin is not enabled.'), 'notice');
}

// Load extension's helper file
JLoader::register('EBHelper', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/helper.php');

NRFramework\Functions::loadLanguage('com_rstbox');
NRFramework\Functions::loadLanguage('plg_system_nrframework');

// Load component backend CSS
JHtml::stylesheet('com_rstbox/engagebox.sys.css', false, true, false);

// Perform the Request task
$controller = JControllerLegacy::getInstance('Rstbox');
$controller->execute($app->input->get('task'));
$controller->redirect();

