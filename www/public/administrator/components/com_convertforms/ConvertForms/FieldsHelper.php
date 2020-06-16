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
 *  ConvertForms Fields Helper Class
 */
class FieldsHelper
{
    /**
     *  List of available field groups and types
     *
     *  Consider using a field class property in order to declare the field group instead.
     *
     *  @var  array
     */
    public static $fields = array(
        'common' => array(
            'text',
            'textarea',
            'dropdown',
            'radio',
            'checkbox',
            'number',
            'email',
            'submit'
        ),
        'userinfo' => array(
            'tel',
            'url',
            'datetime',
            'country',
            'currency',
        ),
        'advanced' => array(
            'hidden',
            'recaptcha',
            'html',
            'termsofservice',
            'confirm'
        )
    );

    /**
     *  Returns a list of all available field groups and types
     *
     *  @return  array  
     */
    public static function getFieldTypes()
    {
        $arr = [];

        foreach (self::$fields as $group => $fields)
        {
            if (!count($fields))
            {
                continue;
            }

            $arr[$group] = array(
                'name'  => $group,
                'title' => \JText::_('COM_CONVERTFORMS_FIELDGROUP_' . strtoupper($group))
            );

            foreach ($fields as $key => $field)
            {
                $arr[$group]['fields'][] = array(
                    'name'  => $field,
                    'title' => \JText::_('COM_CONVERTFORMS_FIELD_' . strtoupper($field)),
                    'desc'  => \JText::_('COM_CONVERTFORMS_FIELD_' . strtoupper($field) . '_DESC'),
                    'class' => self::getFieldClass($field)
                );
            }
        }

        return $arr;
    }

    /**
     *  Render field control group used in the front-end
     *
     *  @param   object  $fields  The fields to render
     *
     *  @return  string           The HTML output
     */
    public static function render($fields)
    {
        $html = array();

        foreach ($fields as $key => $field)
        {
            if (!isset($field->type))
            {
                continue;
            }

            // Skip unknown field types
            if (!$class = self::getFieldClass($field->type))
            {
                continue;
            }

            $html[] = $class->setField($field)->getControlGroup();
        }

        return implode(' ', $html);
    }

    /**
     *  Constructs and returns the field type class
     *
     *  @param   String  $name  The field type name
     *
     *  @return  Mixed          Object on success, Null on failure
     */
    public static function getFieldClass($name)
    {
        $class = __NAMESPACE__ . '\\Field\\' . ucfirst($name);

        if (!class_exists($class))
        {
            return false;
        }

        return new $class();
    }

    public static function prepare(&$form, $classPrefix = 'cf')
    {
        $params = $form['params'];

        $fields = $params->get("fields");

        if (!is_object($fields) || count((array) $fields) == 0)
        {
            return;
        }

        $form['fields'] = array();

        foreach ($fields as $key => &$field)
        {
            if (!isset($field->name) || empty($field->name))
            {
                $field->name = 'unknown' . $key;
            }

            $field->namespace = $form['id'];
            $field->params = new \JRegistry(array());

            // Labels Styles
            $field->labelStyles = array(
                "color:"     . $params->get("labelscolor"),
                "font-size:" . (int) $params->get("labelsfontsize") . "px"
            );

            // Field Classes
            $fieldClasses = array(
                $classPrefix . "-input",
                $classPrefix . "-input-shadow-" . ($params->get("inputshadow", "false") ? "1" : "0"),
                isset($field->size) ? $field->size : null
            );

            // Field Styles
            $fieldStyles = array(
                "text-align:"       . $params->get("inputalign", "left"),
                "color:"            . $params->get("inputcolor", "#888"),
                "background-color:" . $params->get("inputbg"),
                "border-color:"     . $params->get("inputbordercolor", "#ccc"),
                "border-radius:"    . (int) $params->get("inputborderradius", "0") . "px",
                "font-size:"        . (int) $params->get("inputfontsize", "13") . "px",
                "padding:"          . (int) $params->get("inputvpadding", "11") . "px " . (int) $params->get("inputhpadding", "12") . "px"
            ); 

            $field->class = implode(" ", $fieldClasses);
            $field->style = implode(";", $fieldStyles);
            $field->form  = $form;

            $form['fields'][] = $field;
        }

        $form["fields"] = self::render($form['fields']);
    }
}

?>