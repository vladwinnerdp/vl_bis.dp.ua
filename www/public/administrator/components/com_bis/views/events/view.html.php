<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class BisViewEvents extends JViewLegacy
{

    protected $form = null;

    /**
     * Display the Credit Form view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void|boolean
     */
    function display($tpl = null)
    {
        // Get application
        $app = JFactory::getApplication();
        $context = "bis.list.admin.events";


        // Get data from the model
        $this->items		= $this->get('Items');

        $this->pagination	= $this->get('Pagination');
        $this->state		= $this->get('State');


        $this->state      = $this->get('State');
        $this->sortDirection = $this->state->get('list.direction');
        $this->sortColumn = $this->state->get('list.ordering');
        $this->searchterms      = $this->state->get('filter.search');
        $this->filterForm    = $this->get('FilterForm');

        $this->activeFilters = $this->get('ActiveFilters');


        $this->filter_order 	= $app->getUserStateFromRequest($context.'filter_order', 'filter_order', 'sendDate', 'cmd');
        $this->filter_order_Dir = $app->getUserStateFromRequest($context.'filter_order_Dir', 'filter_order_Dir', 'desc', 'cmd');


        // Check for errors.
        if (count($errors = $this->get('Errors')))
        {
            JError::raiseError(500, implode('<br />', $errors));

            return false;
        }
        // Set the toolbar
        $this->addToolBar();

        // Display the template
        parent::display($tpl);

        // Set the document
        $this->setDocument();
    }

    /**
     * Add the page title and toolbar.
     *
     * @return  void
     *
     * @since   1.6
     */
    protected function addToolBar()
    {
        $title = JText::_('COM_BIS_MANAGER_EVENTS');

        if (!empty($this->pagination->total))
        {
            $title .= "<span style='font-size: 0.5em; vertical-align: middle;'>(" . $this->pagination->total . ")</span>";
        }

        JToolBarHelper::title($title, 'events');
        JToolbarHelper::addNew('event.add');
        //JToolBarHelper::custom('users.export', '', '', 'Export',false);
        //JToolBarHelper::deleteList('', 'orders.delete');
        //JToolBarHelper::editList('orders.edit');
    }



    /**
     * Method to set up the document properties
     *
     * @return void
     */
    protected function setDocument()
    {
        $document = JFactory::getDocument();
        $document->setTitle(JText::_('COM_BIS_EVENTS_ADMINISTRATION'));
    }

    /**
     * Returns an array of fields the table can be sorted by
     *
     * @return  array  Array containing the field name to sort by as the key and display text as value
     *
     * @since   3.0
     */
    protected function getSortFields()
    {
        return array(
            'a.id'     => JText::_('JID'),
        );
    }
}