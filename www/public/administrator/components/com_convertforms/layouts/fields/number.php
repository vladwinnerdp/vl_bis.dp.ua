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

<input type="number" name="<?php echo $field->name ?>" id="<?php echo $field->id; ?>"
	<?php if (isset($field->required) && $field->required) { ?>
		required
	<?php } ?>

	<?php if (isset($field->placeholder)) { ?>
		placeholder="<?php echo htmlspecialchars($field->placeholder, ENT_COMPAT, 'UTF-8'); ?>"
	<?php } ?>

	<?php if (isset($field->step) && is_numeric($field->step)) { ?>
		step="<?php echo (float) $field->step; ?>"
	<?php } ?>

	<?php if (isset($field->min) && is_numeric($field->min)) { ?>
		min="<?php echo (float) $field->min; ?>"
	<?php } ?>

	<?php if (isset($field->max) && is_numeric($field->max)) { ?>
		max="<?php echo (float) $field->max; ?>"
	<?php } ?>

	class="<?php echo $field->class ?>"
	style="<?php echo $field->style; ?>"
>