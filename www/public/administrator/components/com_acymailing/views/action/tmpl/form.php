<?php
/**
 * @package	AcyMailing for Joomla!
 * @version	5.10.4
 * @author	acyba.com
 * @copyright	(C) 2009-2018 ACYBA S.A.R.L. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');
?><div id="acy_content">
	<div id="iframedoc"></div>
	<form action="<?php echo acymailing_completeLink('action'); ?>" method="post" name="adminForm" id="adminForm" autocomplete="off">
		<div class="onelineblockoptions">
			<span class="acyblocktitle"><?php echo acymailing_translation('ACY_MAIN_INFORMATIONS'); ?></span>
			<table cellspacing="1" width="100%">
				<tr>
					<td class="acykey">
						<label for="name">
							<?php echo acymailing_translation('ACY_NAME'); ?>
						</label>
					</td>
					<td>
						<input type="text" name="data[action][name]" id="name" class="inputbox" style="width:200px" value="<?php echo $this->escape(@$this->action->name); ?>"/>
					</td>
					<td class="acykey">
						<label for="enabled">
							<?php echo acymailing_translation('ENABLED'); ?>
						</label>
					</td>
					<td>
						<?php echo acymailing_boolean("data[action][published]", '', $this->action->published); ?>
					</td>
				</tr>
				<tr>
					<td class="acykey">
						<label for="delayvalue1">
							<?php echo acymailing_translation('FREQUENCY'); ?>
						</label>
					</td>
					<td>
						<?php $frequency = acymailing_get('type.delay');
						echo $frequency->display('data[action][frequency]', isset($this->action->frequency) ? $this->action->frequency : 900, 1); ?>
					</td>
					<td class="acykey">
						<label for="creator">
							<?php echo acymailing_translation('CREATOR'); ?>
						</label>
					</td>
					<td>
						<input type="hidden" id="actioncreator" name="data[action][userid]" value="<?php echo @$this->action->userid; ?>"/>
						<?php echo '<span id="creatorname">'.@$this->action->creatorname.'</span>';
						echo acymailing_popup(acymailing_completeLink('subscriber', true).'&amp;task=choose&amp;onlyreg=1', '<img src="'.ACYMAILING_IMAGES.'icons/icon-16-edit.png" alt="'.acymailing_translation('ACY_EDIT', true).'"/>');
						?>
					</td>
				</tr>
				<tr>
					<td class="acykey" valign="top">
						<label for="actiondescription">
							<?php echo acymailing_translation('ACY_DESCRIPTION'); ?>
						</label>
					</td>
					<td colspan="3">
						<textarea id="actiondescription" style="width:350px;height;75px;" name="data[action][description]"><?php echo @$this->action->description; ?></textarea>
					</td>
				</tr>
			</table>
		</div>
		<?php
		include(dirname(__FILE__).DS.'configuration.php');
		include(dirname(__FILE__).DS.'conditions.php');
		include(dirname(__FILE__).DS.'actions.php');

		if(!empty($this->action->report)){
			?>
			<div class="onelineblockoptions">
				<span class="acyblocktitle"><?php echo acymailing_translation('REPORT'); ?></span>

				<div id="actionreport"><?php echo nl2br($this->action->report); ?></div>
			</div>
		<?php } ?>
		<div class="clr"></div>

		<input type="hidden" name="cid[]" value="<?php echo @$this->action->action_id; ?>"/>
		<?php acymailing_formOptions(); ?>
	</form>
</div>
