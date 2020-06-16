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

class plgConvertFormsAcyMailing extends \ConvertForms\Plugin
{
	/**
	 *  Main method to store data to service
	 *
	 *  @return  void
	 */
	function subscribe()
	{
		// Create user object
		$user = new stdClass();
		$user->email 	 = $this->lead->email;
		$user->confirmed = $this->lead->campaign->doubleoptin ? false : true;

		$customFields = $this->getCustomFields();

		if (is_array($customFields) && count($customFields))
		{
			foreach ($this->lead->params as $key => $param)
			{
				if (in_array($key, $customFields))
				{
					$user->$key = $param;
				}
			}
		}

		// Save user to database
		$acymailing = acymailing_get('class.subscriber');
		if (!$userid = $acymailing->save($user))
		{
			throw new Exception(JText::_('PLG_CONVERTFORMS_ACYMAILING_CANT_CREATE_USER'));
		}

		// Make sure there's a list selected
		if (!isset($this->lead->campaign->list))
		{
			throw new Exception(JText::_('PLG_CONVERTFORMS_ACYMAILING_NO_LIST_SELECTED'));
		}

		// Subscribe user to AcyMailing lists
		$lead = array();
		foreach($this->lead->campaign->list as $listId)
		{
			$lead[$listId] = array('status' => 1);
		}

		$acymailing->saveSubscription($userid, $lead);
	}

    /**
     *  Returns AcyMailing Service Wrapper File
     *
     *  @return  string
     */
    protected function getWrapperFile()
    {
        return JPATH_ADMINISTRATOR . '/components/com_acymailing/helpers/helper.php';
    }

    /**
     *  Returns an array with AcyMailing custom fields
     *
     *  @return  array
     */
    private function getCustomFields()
    {
    	$db = JFactory::getDbo();

        return $db->setQuery(
            $db->getQuery(true)
                ->select($db->quoteName('namekey'))
                ->from($db->quoteName('#__acymailing_fields'))
        )->loadColumn();
    }
}