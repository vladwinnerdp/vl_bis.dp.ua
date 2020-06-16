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

class plgConvertFormsEmails extends JPlugin
{
    /**
     * Form Object
     *
     * @var object
     */
    private $form;

    /**
     *  Auto loads the plugin language file
     *
     *  @var  boolean
     */
    protected $autoloadLanguage = true;

    /**
     *  Add plugin fields to the form
     *
     *  @param   JForm   $form  
     *  @param   object  $data
     *
     *  @return  boolean
     */
    public function onConvertFormsFormPrepareForm($form, $data)
    {
        $form->loadFile(__DIR__ . '/form/form.xml', false);
        return true;
    }
    
	/**
	 *  Create the final credentials with the auth code
	 *
	 *  @param   string  $context  The context of the content passed to the plugin (added in 1.6)
	 *  @param   object  $article  A JTableContent object
	 *  @param   bool    $isNew    If the content has just been created
	 *
	 *  @return  boolean
	 */
	public function onContentBeforeSave($context, $form, $isNew)
	{
		if ($context != 'com_convertforms.form')
		{
			return;
        }

        if (!is_object($form) || !isset($form->params))
        {
            return;
        }

        $params = json_decode($form->params);

        if (!isset($params->emails))
        {
            return true;
        }

        // Proceed only if Send Notifications option is enabled
        if ($params->sendnotifications != '1')
        {
            return true;
        }

        $this->form = clone $form;
        $this->form->params = $params;

        foreach ($params->emails as $key => $email)
        {
            $keyToID = ((int) str_replace('emails', '', $key)) + 1;
            $error = JText::_('COM_CONVERTFORMS_EMAILS') . ' #' . $keyToID . ' - ';

            $options = [
                'recipient'  => ['COM_CONVERTFORMS_EMAILS_RECIPIENT', true, true],
                'subject'    => ['COM_CONVERTFORMS_EMAILS_SUBJECT', false, true],
                'from_name'  => ['COM_CONVERTFORMS_EMAILS_FROM', false, true],
                'from_email' => ['COM_CONVERTFORMS_EMAILS_FROM_EMAIL', true, true],
                'reply_to'   => ['COM_CONVERTFORMS_EMAILS_REPLY_TO', true, false],
                'body'       => ['COM_CONVERTFORMS_EMAILS_BODY', false, true]
            ];

            foreach ($options as $key => $option)
            {
                $acceptsCommaSeparatedValues = $option[1];
                $optionValues = $acceptsCommaSeparatedValues ? explode(',', $email->$key) : (array) $email->$key;

                foreach ($optionValues as $optionValue)
                {
                    $result = $this->validateOption($optionValue, $option[1], $option[2]);

                    if (is_string($result))
                    {
                        $form->setError($error . JText::_($option[0]) . ' - ' . $result);
                        return false;
                        break;
                    }
                }
            }
        }

        return true;
    }

    /**
     * Validates string as an Email Notification option.
     *
     * @param   string  $string            The option name as found in the xml file
     * @param   bool    $validateAsEmail   If enabled, the option should be validated as an Email Address
     * @param   bool    $required          If enabled, string should not be left blank
     *
     * @return  void
     */
    private function validateOption($string, $validateAsEmail = true, $required = true)
    {
        // Check if it's empty
        if ($required && (empty($string) || is_null($string)))
        {
            return JText::sprintf('PLG_CONVERTFORMS_EMAILS_ERROR_BLANK', $string);
        }

        $string = trim($string);

        // Check if has a valid field-based Smart Tag in the form: {field.field-name}
        $pattern = "#{field.(.*?)}#s";
        preg_match_all($pattern, $string, $result);

        if (!empty($result[0]) && count($result[0]) > 0)
        {
            foreach ($result[0] as $key => $match)
            {
                if (!$this->formHasField($result[1][$key]))
                {
                    return JText::sprintf('PLG_CONVERTFORMS_EMAILS_ERROR_UNKNOWN_SMART_TAG', $match);
                    break;
                }
            }

            return true;
        }

        // Check if has a valid Email Address info@mail.com
        if ($validateAsEmail && !empty($string))
        {
            // Check common email-based Smart Tags
            if (in_array($string, ['{user.email}', '{site.email}']))
            {
                return true;
            }

            if (!ConvertForms\Validate::email($string))
            {
                return JText::sprintf('PLG_CONVERTFORMS_EMAILS_ERROR_INVALID_EMAIL_ADDRESS', $string);
            }
        }

        return true;
    }

    /**
     * Check if given name exists as a form field
     *
     * @param string $name
     *
     * @return bool
     */
    private function formHasField($name)
    {
        foreach ($this->form->params->fields as $key => $field)
        {
            if (isset($field->name) && $field->name == $name)
            {
                return true;
            }
        }

        return false;
    }

    /**
     *  Content is passed by reference, but after the save, so no changes will be saved.
     *  Method is called right after the content is saved.
     * 
     *  @param   string  $lead 		  The Conversion data
     *  @param   bool    $model       The Conversions Model
     *  @param   bool    $isNew       If the Conversion has just been created
     * 
     *  @return  void
     */
    public function onConvertFormsConversionAfterSave($lead, $model, $isNew)
    {
        if (!isset($lead->form->sendnotifications) || !$lead->form->sendnotifications)
        {
            return;
        }

        if (!isset($lead->form->emails) || !is_array($lead->form->emails))
        {
            return;
        }

        // Send email queue
        foreach ($lead->form->emails as $key => $email)
        {
            // Replace {variables}
            $email = ConvertForms\SmartTags::replace($email, $lead);

            // Send mail
            $mailer = new NRFramework\Email($email);
            
            if (!$mailer->send())
            {
                throw new \Exception($mailer->error);
            }
        }
    }   
}