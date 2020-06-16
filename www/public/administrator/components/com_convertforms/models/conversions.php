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

/**
 *  Conversions Class
 */
class ConvertFormsModelConversions extends JModelList
{
    /**
     *  Default table columns
     *
     *  @var  array
     */
    public $default_columns = array(
        'created', 
        'param_email',
        'form_name', 
        'campaign_name', 
        'id'
    );

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     *
     * @see        JController
     */
    public function __construct($config = array())
    {
        if (empty($config['filter_fields']))
        {
            $config['filter_fields'] = array(
                'id', 'a.id',
                'state', 'a.state',
                'created', 'a.created',
                'search',
                'campaign_id', 'a.campaign_id',
                'form_id', 'a.form_id',
                'created_from', 'created_to',
                'columns'
            );
        }

        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @param   string  $ordering   An optional ordering field.
     * @param   string  $direction  An optional direction (asc|desc).
     *
     * @return  void
     *
     * @since   1.6
     */
    protected function populateState($ordering = 'a.id', $direction = 'desc')
    {
        $state = $this->getUserStateFromRequest($this->context . '.filter.state', 'filter_state');
        $this->setState('filter.state', $state);

        $formID = $this->getUserStateFromRequest($this->context . '.filter.form_id', 'filter_form_id');
        $this->setState('filter.form_id', $formID);

        $campaignID = $this->getUserStateFromRequest($this->context . '.filter.campaign_id', 'filter_campaign_id');
        $this->setState('filter.campaign_id', $campaignID);

        $columns = $this->getUserStateFromRequest($this->context . '.filter.columns', 'filter_columns');
        $this->setState('filter.columns', $columns);

        // List state information.
        parent::populateState($ordering, $direction);
    }

    /**
     * Method to build an SQL query to load the list data.
     *
     * @return      string  An SQL query
     */
    protected function getListQuery()
    {
        // Create a new query object.
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);

        // Select some fields from the item table
        $query
            ->select('a.*')
            ->from('#__convertforms_conversions a');
        
        // Filter State
        $filter = $this->getState('filter.state');

        if ($filter != 'skip')
        {
            if (is_numeric($filter))
            {
                $query->where('a.state = ' . ( int ) $filter);
            }
            else if ($filter == '')
            {
                $query->where('( a.state IN (0,1,2))');
            }
        }

        // Join Campaigns Table
        if ($this->getState('filter.join_campaigns') != 'skip')
        {
            $query->select("b.name as campaign_name");
            $query->join('LEFT', $db->quoteName('#__convertforms_campaigns', 'b') . ' ON 
                (' . $db->quoteName('a.campaign_id') . ' = ' . $db->quoteName('b.id') . ')');
        }

        // Join Forms Table
        if ($this->getState('filter.join_forms') != 'skip')
        {
            $query->select("c.name as form_name");
            $query->join('LEFT', $db->quoteName('#__convertforms', 'c') . ' ON 
                (' . $db->quoteName('a.form_id') . ' = ' . $db->quoteName('c.id') . ')');
        }

        // Filter the list over the search string if set.
        $search = $this->getState('filter.search');
        if (!empty($search))
        {
            if (stripos($search, 'id:') === 0)
            {
                $query->where('a.id = ' . ( int ) substr($search, 3));
            }
        }

        // Filter by ID
        if ($id = $this->getState('filter.id'))
        {
            $query->where('a.id IN (' . implode(', ', (array) $id) . ')');
        }

        // Filter by Campaign ID
        if ($campaign_id = $this->getState('filter.campaign_id'))
        {
            $query->where('a.campaign_id IN (' . implode(', ', (array) $campaign_id) . ')');
        }

        // Filter Form
        if ($form_id = $this->getState('filter.form_id'))
        {
            $query->where('a.form_id = ' . $db->q($form_id));
        }

        // Filter created date (from)
        if ($created_from = $this->getState('filter.created_from'))
        {
            $query->where('DATE(a.created) >= ' . $db->q($created_from));
        }

        // Filter created date (to)
        if ($created_to = $this->getState('filter.created_to'))
        {
            $query->where('DATE(a.created) <= ' . $db->q($created_to));
        }

        // Add the list ordering clause.
        $orderCol  = $this->state->get('list.ordering', 'a.id');
        $orderDirn = $this->state->get('list.direction', 'desc');

        $query->order($db->escape($orderCol . ' ' . $orderDirn));

        return $query;
    }
    
    /**
     *  Exports leads in CSV file
     *  Leads can be exported by passing either row IDs or Campaign IDs
     *
     *  @param   array    $ids             Array of row IDs
     *  @param   array    $campaign_ids    Array of Campaign IDs
     *
     *  @return  void
     */
    public function export($ids = array(), $campaign_ids = array())
    {
        $filename = '';
        
        if (is_array($ids) && count($ids))
        {
            $this->setState('filter.id', $ids);
        }

        if (is_array($campaign_ids) && count($campaign_ids))
        {
            $filename = '_Campaign' . $campaign_ids[0];
            $this->setState('filter.state', 1);
            $this->setState('filter.campaign_id', $campaign_ids);
        } else 
        {
            $this->setState('filter.state', 'skip');
        }

        $this->setState('filter.join_campaigns', 'skip');
        $this->setState('filter.join_forms', 'skip');

        $rows = $this->getItems();

        $this->prepareRowsForExporting($rows);

        $columns = array_keys($rows[0]);

        // Create the downloadable file
        $this->downloadFile('ConvertForms_Leads_' . $filename . '_' . date('Y-m-d') . '.csv');
        
        $excel_security = (bool) JComponentHelper::getParams('com_convertforms')->get('excel_security', true);
        echo $this->createCSV($rows, $columns, $excel_security);

        die();
    }

    /**
     *  Prepares rows with their custom fields for exporting
     *
     *  @param   object  &$rows  The rows object
     *
     *  @return  void
     */
    private function prepareRowsForExporting(&$rows)
    {
        $columns = array(
            'id',
            'created',
            'name',
            'email'
        );

        $rows_ = [];

        // Find custom fields per row
        foreach ($rows as $key => $row)
        {
            $rows_[$key]['id'] = $row->id;
            $rows_[$key]['created'] = (string) $row->created;

            foreach ($row->params as $pkey => $param)
            {
                $pkey = trim(strtolower($pkey));

                if (strpos($pkey, 'sync_') !== false)
                {
                    continue;
                }

                $value = is_array($param) ? implode(', ', $param) : $param;

                $rows_[$key][$pkey] = $value;

                if (!in_array($pkey, $columns))
                {
                    array_push($columns, $pkey);
                }
            }
        }

        $rowsNew = array();

        // Fix rows based on columns
        foreach ($columns as $ckey => $column)
        {
            foreach ($rows_ as $rkey => $row)
            {
                $value = isset($row[$column]) ? $row[$column] : '';
                $rowsNew[$rkey][$column] = $value;
            }
        }

        $rows = $rowsNew;
    }

    /**
     *  Create the CSV file
     *
     *  CSV Injection info: https://vel.joomla.org/articles/2140-introducing-csv-injection
     *
     *  @param   array    $rows            CSV Rows to print
     *  @param   array    $columns         CSV Columns to print
     *  @param   boolean  $excel_security  If enabled, certain row values will be prefixed by a tab to avoid any CSV injection
     *
     *  @return  mixed
     */
    public function createCSV($rows, $columns, $excel_security = true)
    {
        ob_start();
        $output = fopen('php://output', 'w');
        fputcsv($output, $columns);

        foreach ($rows as $key => $row)
        {
            // Prevent CSV Injection
            if ($excel_security)
            {
                foreach ($row as $rowKey => &$rowValue)
                {
                    $firstChar = substr($rowValue, 0, 1);

                    // Prefixe values starting with a =, +, - or @ by a tab character
                    if (in_array($firstChar, array('=', '+', '-', '@')))
                    {
                        $rowValue = '    ' . $rowValue;
                    }
                }
            }

            fputcsv($output, $row);
        }

        fclose($output);
        return ob_get_clean();
    }

    /**
     *  Sets propert headers to document to force download of the file
     *
     *  @param   string  $filename  Filename
     *
     *  @return  void
     */
    function downloadFile($filename)
    {
        // disable caching
        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");

        // force download  
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename={$filename}");
        header("Content-Transfer-Encoding: binary");
    }

    /**
     *  [getItems description]
     *
     *  @return  object
     */
    public function getItems()
    {
        $items = parent::getItems();

        foreach ($items as $key => $item)
        {
            $items[$key]->params = json_decode($item->params);

            // Add timezone offset to created date
            $tz = new \DateTimeZone(JFactory::getApplication()->getCfg('offset', 'GMT'));
            $item->created = JFactory::getDate($item->created)->setTimeZone($tz);
        }
        
        return $items;
    }

}