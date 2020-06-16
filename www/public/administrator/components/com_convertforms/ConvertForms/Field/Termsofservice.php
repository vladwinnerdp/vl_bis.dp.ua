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

class Termsofservice extends \ConvertForms\Field
{
	/**
	 *  Filter user value before saving into the database.
	 *
	 *  @var  string
	 */
	protected $filterInput = 'BOOL';

	/**
	 *  Remove common fields from the form rendering
	 *
	 *  @var  mixed
	 */
	protected $excludeFields = array(
		'placeholder',
		'value',
		'browserautocomplete',
		'required',
		'size',
		'inputmask'
	);    

	/**
	 *  Validate field value
	 *
	 *  @param   mixed  $value           The field's value to validate (Passed by reference)
	 *  @param   array  $field_options   The field's options (Entered in the backend)
	 *  @param   array  $form_data       The form submitted data
	 *
	 *  @return  mixed                   True on success, throws an exception on error
	 */
	public function validate(&$value, $field_options, $form_data)
	{
		$field_options['required'] = true;
		parent::validate($value, $field_options, $form_data);
	}
}

?>