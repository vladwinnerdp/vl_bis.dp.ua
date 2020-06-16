<?php
defined('_JEXEC') or die('Restricted access');


class BisModelEvents extends JModelList
{
    /**
     * Constructor.
     *
     * @param   array  $config  An optional associative array of configuration settings.
     *
     * @see     JControllerLegacy
     * @since   1.6
     */
    public function __construct($config = array())
    {
        if (empty($config['filter_fields']))
        {
            $config['filter_fields'] = array(
                'date', 'a.created',
            );
        }

        parent::__construct($config);
    }

    /**
     * Method to build an SQL query to load the list data.
     *
     * @return      string  An SQL query
     */
    protected function getListQuery()
    {
        // Initialize variables.
        $db    = JFactory::getDbo();
        $query = $db->getQuery(true);

        // Filter by search in title
        $search = $this->getState('filter.search');

        // Create the base select statement.
        $query->select('a.id, a.name, a.image, a.difficulty, a.url, a.published, a.created, a.modified, a.type')
            ->from($db->quoteName('#__pl_events', 'a'))
        ;


        if (!empty($search))
        {
            $search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
            $query->where('(a.name LIKE ' . $search . ')');
        }


        $listOrdering  = $this->state->get('list.ordering', 'id');
        $orderDirn     = $this->state->get('list.direction', 'DESC');

        $query->order($db->escape($listOrdering) . ' ' . $db->escape($orderDirn));

        return $query;
    }

}
