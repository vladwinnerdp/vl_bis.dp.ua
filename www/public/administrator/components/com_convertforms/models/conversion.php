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

use Joomla\Registry\Registry;
use Joomla\String\StringHelper;
use Joomla\Filter\InputFilter;
use ConvertForms\FieldsHelper;

defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');

/**
 * Conversion Model Class
 */
class ConvertFormsModelConversion extends JModelAdmin
{
    /**
     *  The database object
     *
     *  @var  object
     */
    private $db;

    /**
     * Constructor.
     *
     * @param   array  $config  An optional associative array of configuration settings.
     *
     * @see     JModelLegacy
     * @since   1.6
     */
    public function __construct($config = array())
    {
        parent::__construct($config);
        $this->db = JFactory::getDbo();
    }

    /**
     * Returns a reference to the a Table object, always creating it.
     *
     * @param       type    The table type to instantiate
     * @param       string  A prefix for the table class name. Optional.
     * @param       array   Configuration array for model. Optional.
     * @return      JTable  A database object
     * @since       2.5
     */
    public function getTable($type = 'Conversion', $prefix = 'ConvertFormsTable', $config = array()) 
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Method to get the record form.
     *
     * @param       array   $data           Data for the form.
     * @param       boolean $loadData       True if the form is to load its own data (default case), false if not.
     * @return      mixed   A JForm object on success, false on failure
     * @since       2.5
     */
    public function getForm($data = array(), $loadData = true)
    {
        // Get the form.
        $form = $this->loadForm('com_convertforms.conversion', 'conversion', array('control' => 'jform', 'load_data' => $loadData));

        if (empty($form)) 
        {
            return false;
        }

        return $form;
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @return    mixed    The data for the form.
     */
    protected function loadFormData()
    {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState('com_convertforms.edit.conversion.data', array());

        if (empty($data))
        {
            $data = $this->getItem();
        }

        return $data;
    }

    /**
     *  Validate data before saving
     *
     *  @param   object  $form   The form to validate
     *  @param   object  $data   The data to validate
     *  @param   string  $group  
     *
     *  @return  array           The validated data
     */
    public function validate($form, $data, $group = null)
    {
        // Make sure we have a valid Form ID passed
        if (!isset($data['cf']['form_id']) || !$formid = (int) $data['cf']['form_id'])
        {
            throw new Exception('Form ID is either missing or invalid');
        }

        // Load the Form data from the database
        $form = JModelLegacy::getInstance('Form', 'ConvertFormsModel', array('ignore_request' => true))->getItem($formid);

        // Make sure the right form is loaded
        if (is_null($form->id))
        {
            throw new Exception('Unknown Form');
        }

        // Initialize the object that is going to be saved in the database
        $newData = array(
            'form_id'     => $formid,
            'campaign_id' => (int) $form->campaign
        );

        // Let's validate submitted data
        foreach ($form->fields as $key => $form_field)
        {
            $field_name  = isset($form_field['name']) ? $form_field['name'] : null;
            $field_class = FieldsHelper::getFieldClass($form_field['type']);
            $user_value  = (!is_null($field_name) && isset($data['cf'][$field_name])) ? $data['cf'][$field_name] : null;
            
            // Validate and Filter user value. If an error occurs the submission aborts with an exception shown in the form
            $field_class->validate($user_value, $form_field, $data);

            // Skip unknown fields or fields with an empty value
            if (!$field_name || !$user_value)
            {
                continue;
            }

            $newData['params'][$field_name] = $user_value;
        }

        $newData['params'] = json_encode($newData['params']);

        return $newData;
    }

    /**
     *  Create a new conversion based on the post data.
     *
     *  @return  object     The new conversion row object
     */
    public function createConversion($data)
    {
        // Validate data
        $data = $this->validate(null, $data);

        // Log debug message
        $debugData = urldecode(http_build_query($data, '', ', '));
        ConvertForms\Helper::log('New Lead: ' . $debugData);

        // Everything seems fine. Let's save data to the database.
        if (!$this->save($data))
        {
            throw new Exception($this->getError());
        }

        return $this->getItem();
    }

    /**
     *  Get a conversion item
     *
     *  @param   interger  $pk  The conversion row primary key
     *
     *  @return  object         The conversion object
     */
    public function getItem($pk = null)
    {
        if (!$item = parent::getItem($pk))
        {
            return;
        }

        // Load Form & Campaign Model
        $modelForm = JModelLegacy::getInstance('Form', 'ConvertFormsModel', array('ignore_request' => true));
        $modelCampaign = JModelLegacy::getInstance('Campaign', 'ConvertFormsModel', array('ignore_request' => true));

        $item->form = $modelForm->getItem($item->form_id);
        $item->campaign = $modelCampaign->getItem($item->campaign_id);

        return $item;
    }
}

