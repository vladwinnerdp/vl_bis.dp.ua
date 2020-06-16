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
extract($displayData);

?>

<div class="cf-checkbox-group">
	<input type="checkbox" name="<?php echo $field->name ?>" id="<?php echo $field->id; ?>"
		required
		value="1"
		class="<?php echo $field->class; ?>"
	>
	<label class="cf-label" for="<?php echo $field->id; ?>">
		<?php if (!empty($field->terms_url)) { ?>
			<a target="_blank" href="<?php echo $field->terms_url; ?>">
		<?php } ?>

		<?php echo $field->terms_text ?>

		<?php if (!empty($field->terms_url)) { ?>
			</a>
		<?php } ?>
	</label>
</div>