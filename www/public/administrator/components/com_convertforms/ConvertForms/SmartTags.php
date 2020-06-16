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

namespace ConvertForms;

defined('_JEXEC') or die('Restricted access');

class SmartTags
{
	public static $smartTags = array(
        'lead.id'          => '',
        'lead.date'        => '',
        'lead.campaign_id' => '',
        'lead.form_id'     => '',
        'lead.visitor_id'  => '',
        'all_fields'       => ''
    );

	public static function get()
    {
        return self::$smartTags;
    }

    public static function prepare($lead = null, $form_id = null)
    {
        $tags = array();

        if (!is_object($lead) && is_int($lead))
        {
            // Add component include paths for models and tables
            $path = JPATH_ADMINISTRATOR . '/components/com_convertforms/';
            \JModelLegacy::addIncludePath($path . 'models');
            \JTable::addIncludePath($path . 'tables');

            $model = \JModelLegacy::getInstance('Conversion', 'ConvertFormsModel', array('ignore_request' => true));
            $lead = $model->getItem($lead);
        }

        if (is_object($lead))
        {
            $form_id = is_null($form_id) ? $lead->form_id : $form_id;

            $tags = array(
                'lead.id'          => $lead->id,
                'lead.date'        => $lead->created,
                'lead.campaign_id' => $lead->campaign_id,
                'lead.form_id'     => $lead->form_id,
                'lead.visitor_id'  => $lead->visitor_id
            );

            $all_fields = '';

            if (is_array($lead->params))
            {
                foreach ($lead->params as $key => $value)
                {
                    // Skip integration wide fields
                    if (strpos($key, 'sync_') !== false)
                    {
                        continue;
                    }

                    $value = is_array($value) ? implode(', ', $value) : nl2br($value);
                    $tags['field.' . $key] = $value;
                    $all_fields .= '<div><strong>' . ucfirst($key) . '</strong>: ' . $value . '</div>';
                }

                $tags['all_fields'] = $all_fields;
            }
        }

        $tags['leads.count'] = $form_id ? Helper::getFormLeadsCount($form_id) : '0';

        return $tags;
    }

    public static function replace(&$string, $lead = null, $form_id = null)
    {
        $smartTags = new \NRFramework\SmartTags();
        $localTags = self::prepare($lead, $form_id);
        $smartTags->add($localTags);
        $result = $smartTags->replace($string);

        // This code block removes unreplaced querystring Smart Tags. Should be moved to framework.
        $pattern = "#{querystring.(.*?)}#s";
        $result = preg_replace($pattern, '', $result);

        return $result;
    }
}

?>