<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');


class BisModelEvent extends JModelAdmin
{
    /**
     * Method to get a table object, load it if necessary.
     *
     * @param   string  $type    The table name. Optional.
     * @param   string  $prefix  The class prefix. Optional.
     * @param   array   $config  Configuration array for model. Optional.
     *
     * @return  JTable  A JTable object
     *
     * @since   1.6
     */
    public function getTable($type = 'Event', $prefix = 'BisTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Method to get the record form.
     *
     * @param   array    $data      Data for the form.
     * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
     *
     * @return  mixed    A JForm object on success, false on failure
     *
     * @since   1.6
     */
    public function getForm($data = array(), $loadData = true)
    {
        // Get the form.
        $form = $this->loadForm(
            'com_bis.event',
            'event',
            array(
                'control' => 'jform',
                'load_data' => $loadData
            )
        );

        if (empty($form))
        {
            return false;
        }

        return $form;
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @return  mixed  The data for the form.
     *
     * @since   1.6
     */
    protected function loadFormData()
    {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState(
            'com_bis.edit.event.data',
            array()
        );

        if (empty($data))
        {
            $data = $this->getItem();
        }
        switch ($data->puzzle_type) {
            case 'missing_letters':
                $data = $this->restoreMissingLettersParams($data);
                break;
            case 'images':
                $data = $this->restoreImagesParams($data);
                break;
            case 'millionaire':
                $data = $this->restoreMillionaireParams($data);
                break;
            case 'findme':
                $data = $this->restoreFindme($data);
                break;
        }


        return $data;
    }

    protected function prepareTable($table)
    {
        $date = JFactory::getDate();
        $table->modified    = $date->toSql();

        if (empty($table->id)) {
            $table->created    = $date->toSql();
        }
    }

    public function save($data)
    {
        switch($data['puzzle_type']) {
            case 'millionaire':
                $data = $this->processMillionaire($data);
                break;
        }
        return parent::save($data);
    }

    public function restoreMillionaireParams($data)
    {
        if (!empty($data->params['questions'])) {
            $data->millionaire_question = $data->params['questions'];

        }
        if (!empty($data->params['html'])) {
            $data->html = $data->params['html'];
        }
            
        return $data;
    }


    public function processMillionaire($data)
    {
        $data['params'] = array();

        if ($data['millionaire_question']) {
            foreach($data['millionaire_question'] as $question) {
                $data['params']['questions'][] = $question;
            }
        }
	if ($data['html']) {
            $data['params']['html'] = $data['html'];
        }

        $data['params'] = json_encode($data['params']);

        return $data;
    }


}