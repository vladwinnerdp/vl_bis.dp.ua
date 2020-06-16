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

?>

<table class="table nrTable noBorder">
	<tbody>
		<tr>
			<td><?php echo JText::_("NR_EXTENSION"); ?></td>
			<td><?php echo JText::_("COM_CONVERTFORMS"); ?></td>
		</tr>	
		<tr>
			<td><?php echo JText::_("NR_VERSION"); ?></td>
			<td><?php echo NRFramework\Functions::getExtensionVersion("com_convertforms", true); ?>
				<a href="http://www.tassos.gr/joomla-extensions/convert-forms/#changelog"><?php echo JText::_("NR_CHANGELOG"); ?></a>
			</td>
		</tr>
		<tr>
			<td><?php echo JText::_("NR_DOWNLOAD_KEY"); ?></td>
			<td>
				<?php if ($downloadKey) { ?>
				<span class="label label-success"><?php echo JText::_("NR_OK"); ?></span>
				<?php } else { ?>
				<span class="label label-important"><?php echo JText::_("NR_MISSING"); ?></span>
				<?php } ?>
			</td>
		</tr>
		<tr>
			<td><?php echo JText::_("NR_LICENSE"); ?></td>
			<td><a href="http://www.tassos.gr/license" target="_blank">GNU GPLv3 Commercial</td>
		</tr>
		<tr>
			<td><?php echo JText::_("NR_AUTHOR"); ?></td>
			<td>Tassos Marinos - <a href="http://www.tassos.gr" target="_blank">www.tassos.gr</td>
		</tr>
		<tr>
			<td><?php echo JText::_("NR_FOLLOWME"); ?></td>
			<td><a href="#" onclick="window.open('https://twitter.com/intent/follow?screen_name=tassosm','tassos.gr','width=500,height=500');"><span class="label label-info"><?php echo JText::sprintf("NR_FOLLOW", "@mtassos") ?></span></a></td>
		</tr>
	</tbody>
</table>