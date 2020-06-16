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

<input type="<?php echo $field->type; ?>" name="<?php echo $field->name ?>" id="<?php echo $field->id; ?>"
	<?php if (isset($field->required) && $field->required) { ?>
		required
	<?php } ?>

	<?php if (isset($field->placeholder) && !empty($field->placeholder)) { ?>
		placeholder="<?php echo htmlspecialchars($field->placeholder, ENT_COMPAT, 'UTF-8'); ?>"
	<?php } ?>

	<?php if (isset($field->value) && !empty($field->value)) { ?>
		value="<?php echo $field->value; ?>"
	<?php } ?>
	
	<?php if (isset($field->browserautocomplete) && $field->browserautocomplete == '1') { ?>
		autocomplete="off"
	<?php } ?>

	<?php if (isset($field->inputmask) && !empty($field->inputmask)) { ?>
		data-inputmask-mask="<?php echo $field->inputmask ?>"
	<?php } ?>

	class="<?php echo $field->class ?>"
	style="<?php echo $field->style; ?>"
>