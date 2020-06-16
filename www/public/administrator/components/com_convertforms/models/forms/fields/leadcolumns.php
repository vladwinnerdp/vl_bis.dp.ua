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
JFormHelper::loadFieldClass('checkboxes');

class JFormFieldLeadColumns extends JFormFieldCheckboxes
{
    /**
     * Method to get a list of options for a list input.
     *
     * @return      array           An array of JHtml options.
     */
    protected function getOptions()
    {
        $formID  = $this->getFormID();
        $options = parent::getOptions();

        // Add form-based field options
        if (!$formID)
        {
            return $options;
        }

        $model = JModelLegacy::getInstance('Form', 'ConvertFormsModel', array('ignore_request' => true));

        if (!$form = $model->getItem($formID))
        {
            return $options;
        }

        $optionsForm = array();

        foreach ($form->fields as $key => $field)
        {
            if (!isset($field['name']))
            {
                continue;
            }

            $optionsForm[] = (object) [
                'value'   => 'param_' . $field['name'],
                'text'    => ucfirst($field['name'])
            ];
        }

        // Always display the date submitted as the 1st table column
        $options = array_merge(array_slice($options, 0, 1), $optionsForm, array_slice($options, 1, count($options)));

        return $options;
    }

    protected function getInput()
    {
        if (is_null($this->value) || empty($this->value) || (is_array($this->value) && count(array_filter($this->value)) == 0))
        {
            $model = JModelLegacy::getInstance('Conversions', 'ConvertFormsModel', array('ignore_request' => true));
            $this->value = $model->default_columns;
        }

        JFactory::getDocument()->addStyleDeclaration('
            .chooseColumns {
                position:relative;
            }
            .chooseColumnsOptions {
                position: absolute;
                background-color: #fff;
                top: 30px;
                border-radius:4px;
                z-index:15; 
                transition: height 0.01s;
            }
            .chooseColumnsOptions.in {
                -webkit-box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.1);
                box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.1);
            }
            .chooseColumnsOptions > div {
                border: solid 1px #ccc;
                padding: 15px;
                min-width: 150px;
                border-radius:4px; 
            }
            .chooseColumnsOptions fieldset {
                margin-bottom:5px;
            }
            .chooseColumnsOptions fieldset .checkbox {
                white-space: nowrap;
            }
            .chooseColumnsOptions input {
                margin-top: 2px;
            }
            .chooseColumnsInfo {
                padding-top: 10px;
                line-height: 16px;
                font-size: 11px;
                color: #555;
            }
        ');

        $html = '
            <div class="chooseColumns">
                <button class="btn" role="button" data-toggle="collapse" href=".chooseColumnsOptions">'
                     . JText::_('COM_CONVERTFORMS_CHOOSE_COLUMNS') . '
                </button>
                <div class="collapse chooseColumnsOptions">
                    <div>
                        ' . parent::getInput() . '
                        <button class="btn btn-primary" onclick="this.form.submit();">'
                            . JText::_('JAPPLY') . 
                        '</button>';

        if (!$this->getFormID())
        {
            $html .= '<div class="chooseColumnsInfo">' . JText::_('COM_CONVERTFORMS_CHOOSE_COLUMNS_OPTIONS') . '</div>';
        }

        $html .= '
                    </div>
                </div>
            </div>
        ';

        return $html;
    }

    private function getFormID()
    {
        return JFactory::getApplication()->getUserState('com_convertforms.conversions.filter.form_id');
    }
}