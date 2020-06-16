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

class Confirm extends \ConvertForms\Field
{
	protected $inheritInputLayout = 'text';

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
		parent::validate($value, $field_options, $form_data);

		$confirmField = $field_options['confirmfield'];

		if (empty($confirmField) || !isset($form_data['cf'][$confirmField]))
		{
			$this->throwError('COM_CONVERTFORMS_FIELD_CONFIRM_INVALID', $field_options);
		}

		$confirmFieldValue = $form_data['cf'][$confirmField];

		if ($confirmFieldValue !== $value)
		{
			$this->throwError('COM_CONVERTFORMS_FIELD_CONFIRM_NOT_MATCH', $field_options);
		}
	}
}

?>