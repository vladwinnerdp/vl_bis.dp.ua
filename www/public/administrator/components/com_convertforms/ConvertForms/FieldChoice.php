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

namespace ConvertForms;

defined('_JEXEC') or die('Restricted access');

/**
 *  Convert Forms Field Choice Class
 *  Used by dropdown and checkbox fields
 */
class FieldChoice extends \ConvertForms\Field
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
	 *  Set field object
	 *
	 *  @param  mixed  $field  Object or Array Field options
	 */
	public function setField($field)
	{
		parent::setField($field);

		$this->field->choices = $this->getChoices();

		return $this;
	}

	/**
	 *  Set the field choices
	 *
	 *  Return Array sample
	 *
	 *  $choices = array(
     *  	'label'    => 'Color',
     *   	'value'    => 'color,
     *  	'selected' => true,
     *   	'disabled' => false
	 *  )
	 *
	 *  @return  array  The field choices array
	 */
	protected function getChoices()
	{
		$field = $this->field;

		if (!isset($field->choices) || !isset($field->choices->choices))
        {
            return;
        }

        $choices = array();
        $hasPlaceholder = (isset($field->placeholder) && !empty($field->placeholder));

        // Create a new array of valid only choices
        foreach ($field->choices->choices as $key => $choiceValue)
        {
            if (!isset($choiceValue->label) || empty($choiceValue->label))
            {
                continue;
            }

            $label = trim($choiceValue->label);
            $value = empty($choiceValue->value) ? $label : $choiceValue->value;

            $choices[] = array(
                'label'    => $label,
                'value'    => $value,
                'selected' => (isset($choiceValue->default) && $choiceValue->default && !$hasPlaceholder) ? true : false
            );
        }

        // If we have a placeholder available, add it to dropdown choices.
        if ($hasPlaceholder)
        {
            array_unshift($choices, array(
                'label'    => trim($field->placeholder),
                'value'    => '',
                'selected' => true,
                'disabled' => true
            ));
        }

        return $choices;
	}
}
?>