<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

class BisTableEvent extends JTable
{
    /**
     * Constructor
     *
     * @param   JDatabaseDriver  &$db  A database connector object
     */
    function __construct(&$db)
    {
        parent::__construct('#__pl_events', 'id', $db);
    }
}
