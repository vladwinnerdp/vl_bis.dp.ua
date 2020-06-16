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

namespace ConvertForms\Field;

defined('_JEXEC') or die('Restricted access');

use ConvertForms\Validate;
use Joomla\String\StringHelper;

class DateTime extends \ConvertForms\Field
{
	/**
	 *  Remove common fields from the form rendering
	 *
	 *  @var  mixed
	 */
	protected $excludeFields = array(
		'browserautocomplete',
		'inputmask'
	);

	/**
	 *  Validate field value
	 *
	 *  @param   mixed  $value           The field's value to validate
	 *  @param   array  $field_options   The field's options (Entered in the backend)
	 *  @param   array  $form_data       The form submitted data
	 *
	 *  @return  mixed                   True on success, throws an exception on error
	 */
	public function validate(&$value, $field_options, $form_data)
	{
		$parent = parent::validate($value, $field_options, $form_data);

		if ($parent)
		{
			return true;
		}

		// Check if we have a date range passed
		if ($field_options['mode'] == 'range')
		{
			$value = explode('to', $value);			
		}

		// Check if we have multiple dates passed
		if ($field_options['mode'] == 'multiple')
		{
			$value = explode(',', $value);			
		}

		$value = is_array($value) ? $value : array($value);

		// Validate all dates
		foreach ($value as $date)
		{
			if (!Validate::dateFormat($date, $field_options['dateformat']))
			{
				$this->throwError(\JText::sprintf('COM_CONVERTFORMS_FIELD_DATETIME_INVALID', $date), $field_options);
			}
		}
	}

	/**
	 *  Prepares the field's input layout data in order to support PHP date relative formats such as
	 *  first day of this month, next week, +5 day e.t.c
	 *
	 *  http://php.net/manual/en/datetime.formats.relative.php
	 *  
	 *  @return  array
	 */
	protected function getInputData()
	{
		$data = parent::getInputData();

		$properties = array(
			'value',
			'mindate',
			'maxdate',
			'placeholder'
		);

		// Make sure we have a valid dateformat
		$dateFormat = $data['field']->dateformat ?: 'd/m/Y';

		foreach ($properties as $key => $property)
		{
			if (!isset($data['field']->$property) || empty($data['field']->$property))
			{
				continue;
			}

			// Try to format the date property.
			try {
				$date = new \JDate($data['field']->$property);
				$data['field']->$property = $date->format($dateFormat);
			} catch (\Exception $e) {
				
			}
		}

		return $data;
	}
}

?>