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

if (!@include_once(JPATH_PLUGINS . '/system/nrframework/autoload.php'))
{
	throw new RuntimeException('Novarain Framework is not installed', 500);
}

// Initialize Convert Forms Library
require_once JPATH_ADMINISTRATOR . '/components/com_convertforms/autoload.php';

if (!NRFramework\Extension::pluginIsEnabled('convertforms'))
{
	JFactory::getApplication()->enqueueMessage(JText::_('Convert Forms plugin is not enabled.'), 'error');
}

if (!NRFramework\Extension::componentIsEnabled('ajax'))
{
	JFactory::getApplication()->enqueueMessage(JText::_('AJAX Component is not enabled.'), 'error');
}

NRFramework\Functions::loadLanguage('com_convertforms');

$app = JFactory::getApplication();

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_convertforms'))
{
	$app->enqueueMessage(JText::_('JERROR_ALERTNOAUTHOR'), 'error');
	return;
}

// Load component's CSS/JS files
ConvertForms\Helper::loadassets();

// Perform the Request task
$controller = JControllerLegacy::getInstance('ConvertForms');
$controller->execute($app->input->get('task'));
$controller->redirect();
