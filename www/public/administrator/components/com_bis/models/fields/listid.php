<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JFormHelper::loadFieldClass('list');


class JFormFieldListId extends JFormFieldList
{
    /**
     * The field type.
     *
     * @var         string
     */
    protected $type = 'ListId';

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
        $query->from('#__acymailing_list');
        $query->where('type = "list"');
        $db->setQuery((string) $query);
        $messages = $db->loadObjectList();
        $options  = array();

        if ($messages)
        {
            $options[] = JHtml::_('select.option', "", "Выбрать рассылку");
            foreach ($messages as $message)
            {
                $options[] = JHtml::_('select.option', $message->listid, $message->name);
            }
        }

        $options = array_merge(parent::getOptions(), $options);

        return $options;
    }
}