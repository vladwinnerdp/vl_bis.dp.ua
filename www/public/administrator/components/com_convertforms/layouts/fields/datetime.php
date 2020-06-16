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

$doc = JFactory::getDocument();

// Load flatpickr media files
JHtml::stylesheet('com_convertforms/flatpickr.min.css', ['relative' => true, 'version' => 'auto']);
JHtml::script('com_convertforms/flatpickr.js', ['relative' => true, 'version' => 'auto']);

// Load selected theme
if ($field->theme)
{
	JHtml::stylesheet('com_convertforms/flatpickr.' . $field->theme . '.css', ['relative' => true, 'version' => 'auto']);
}

// Setup plugin options
$options = array(
	'mode'	     	  => $field->mode,
	'dateFormat' 	  => $field->dateformat,
	'defaultDate'	  => $field->value,
	'minDate'	 	  => $field->mindate,
	'maxDate'	 	  => $field->maxdate,
	'enableTime'	  => (bool) $field->showtimepicker,
	'time_24hr'  	  => (bool) $field->time24,
	'minuteIncrement' => $field->minuteincrement,
	'inline'	 	  => (bool) $field->inline,
	'disableMobile'	  => isset($field->disable_mobile) ? (bool) $field->disable_mobile : false
);

// Localize
$lang = strtolower(explode('-', \JFactory::getLanguage()->getTag())[1]);
if (!in_array($lang, ['gb', 'us'])) // Skip english
{
	$options['locale'] = $lang;
	$doc->addScriptDeclaration('flatpickr.localize(flatpickr.l10ns.' . $lang . ');');
	$doc->addScript('//npmcdn.com/flatpickr/dist/l10n/' . $lang . '.js');
}

// Setup plugin
$doc->addScriptDeclaration('
	document.addEventListener("DOMContentLoaded", function(event) { 
		flatpickr.l10ns.default.firstDayOfWeek = 1;
		flatpickr("#' . $field->id .'", ' . json_encode($options, JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK) . ');
	});
');

$doc->addStyleDeclaration('
	.flatpickr-calendar .flatpickr-time input {
		height: auto !important;
		border: none !important;
		box-shadow: none !important;
		font-size: 14px !important;
		margin: 0 !important;
		padding: 0 !important;
		line-height: inherit !important;
		background: none !important;
		color: ' . ($field->theme == "dark" ? "#fff" : "#484848")  . ' !important;
	}
	.flatpickr-calendar.inline {
		margin-top:5px;
	}
');

?>

<input type="text" name="<?php echo $field->name ?>" id="<?php echo $field->id; ?>"
	<?php if (isset($field->required) && $field->required) { ?>
		required
	<?php } ?>

	<?php if (isset($field->placeholder) && !empty($field->placeholder)) { ?>
		placeholder="<?php echo htmlspecialchars($field->placeholder, ENT_COMPAT, 'UTF-8'); ?>"
	<?php } ?>

	<?php if (isset($field->value) && !empty($field->value)) { ?>
		value="<?php echo $field->value; ?>"
	<?php } ?>

	autocomplete="off"
	class="<?php echo $field->class ?>"
	style="<?php echo $field->style; ?>"
>