<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JFormHelper::loadFieldClass('list');


class JFormFieldMailId extends JFormFieldList
{
    /**
     * The field type.
     *
     * @var         string
     */
    protected $type = 'MailId';

    /**
     * Method to get a list of options for a list input.
     *
     * @return  array  An array of JHtml options.
     */
    protected function getOptions()
    {
        $db    = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__acymailing_mail');
		$query->where('type = "news"');
        $db->setQuery((string) $query);
        $messages = $db->loadObjectList();
        $options  = array();

        if ($messages)
        {
            $options[] = JHtml::_('select.option', "", "Выбрать письмо");
            foreach ($messages as $message)
            {
                $options[] = JHtml::_('select.option', $message->mailid, $message->subject);
            }
        }

        $options = array_merge(parent::getOptions(), $options);

        return $options;
    }
}