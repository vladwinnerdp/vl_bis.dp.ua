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

<?php if (count($this->latestleads)) { ?>
	<table class="table nrTable">
		<thead>
			<tr>
				<th><?php echo JText::_("COM_CONVERTFORMS_EMAIL") ?></th>
				<th><?php echo JText::_("COM_CONVERTFORMS_CAMPAIGN") ?></th>
				<th width="30%"><?php echo JText::_("JDATE") ?></th>
			</tr>
			<tbody>
				<?php foreach ($this->latestleads as $key => $lead) { ?>
				<tr class="<?php echo isset($lead->params->sync_error) ? "error" : "" ?>">
					<td>
						<?php 
							$email = '';

							foreach ($lead->params as $param_key => $param_value)
							{
								if (strtolower($param_key) == 'email')
								{
									$email = $param_value;
									break;
								}
							}

							echo $email;
						?>
	                    <?php if (isset($lead->params->sync_error)) { ?>
	                        <span class="hasPopover icon icon-info" 
	                            data-placement="top"
	                            data-content="<?php echo $lead->params->sync_error ?>"
	                            style="color:red;">
	                        </span>
	                    <?php } ?>
					</td>
					<td><?php echo $lead->campaign_name ?></td>
					<td><?php echo $lead->created;  ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</thead>
	</table>
<?php } else { ?>
	<div class="text-center">
		<?php echo ConvertForms\Helper::noItemsFound(); ?>
	</div>
<?php } ?>