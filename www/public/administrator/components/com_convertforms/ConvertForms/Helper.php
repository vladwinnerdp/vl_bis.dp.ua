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

use NRFramework\Cache;

jimport('joomla.log.log');

class Helper
{
    public static function getComponentParams()
    {
        $hash = 'cfComponentParams';

        if (Cache::has($hash))
        {
            return Cache::get($hash);
        }

        return Cache::set($hash, \JComponentHelper::getParams('com_convertforms'));
    }

    public static function getFormLeadsCount($form)
    {
        if (!$form || $form == 0)
        {
            return 0;
        }

        $db = \JFactory::getDBO();
        $query = $db->getQuery(true);

        $query
            ->select('count(*)')
            ->from('#__convertforms_conversions')
            ->where('form_id = ' . $form)
            ->where('state = 1');

        $db->setQuery($query);

        return $db->loadResult();
    }

    public static function getLayoutsPath()
    {
        return JPATH_ADMINISTRATOR . '/components/com_convertforms/layouts';
    }

    /**
     *  Renders form template selection modal to the document
     *
     *  @return   void
     */
    public static function renderSelectTemplateModal()
    {
        echo JHtml::_('bootstrap.renderModal', 'cfSelectTemplate', array(
            'url'         => 'index.php?option=com_convertforms&view=templates&tmpl=component',
            'title'       => \JText::_('COM_CONVERTFORMS_TEMPLATES_SELECT'),
            'closeButton' => true,
            'height'      => '100%',
            'width'       => '100%',
            'modalWidth'  => '70',
            'bodyHeight'  => '70',
            'footer'      => '
                <a href="' . \JURI::base() . 'index.php?option=com_convertforms&view=form&layout=edit" class="btn btn-primary">
                    <span class="icon-new"></span> ' . \JText::_('COM_CONVERTFORMS_TEMPLATES_BLANK') . '
                </a>
            '
        ));
    }

    /**
     *  Writes the Not Found Items message
     *
     *  @param   string  $view 
     *
     *  @return  string
     */
    public static function noItemsFound($view = "leads")
    {
        $html[] = '<span style="font-size:16px; position:relative; top:2px;" class="icon-smiley-sad-2"></span>';
        $html[] = \JText::sprintf('COM_CONVERTFORMS_NO_RESULTS_FOUND', \JText::_('COM_CONVERTFORMS_' . $view));

        return implode(' ', $html);
    }

    /**
     *  Get Latest Leads
     *
     *  @param   integer  $limit  The max number of lead records
     *
     *  @return  object
     */
    public static function getLatestLeads($limit = 10)
    {
        $model = \JModelLegacy::getInstance('Conversions', 'ConvertFormsModel', array('ignore_request' => true));
        $model->setState('list.limit', 10);

        return $model->getItems();
    }

    /**
     *  Get Visitor ID
     *
     *  @return  string
     */
    public static function getVisitorID()
    {
        return \NRFramework\VisitorToken::getInstance()->get();
    }

    /**
     *  Returns campaigns list visitor is subscribed to
     *  If the user is logged in, we try to get the campaigns by user's ID
     *  Otherwise, the visitor cookie ID will be used instead
     *
     *  @return  array  List of campaign IDs
     */
    public static function getVisitorCampaigns()
    {
        $db    = \JFactory::getDBO();
        $query = $db->getQuery(true);
        $user  = \JFactory::getUser();

        $query
            ->select('campaign_id')
            ->from('#__convertforms_conversions')
            ->where('state = 1')
            ->group('campaign_id');

        // Get leads by user id if visitor is logged in
        if ($user->id)
        {
            $query->where('user_id = ' . (int) $user->id);
        } else 
        {
            // Get leads by Visitor Cookie
            if (!$visitorID = self::getVisitorID())
            {
                return false;
            }

            $query->where('visitor_id = ' . $db->q($visitorID));
        }

        $db->setQuery($query);
        return $db->loadColumn();
    }

    /**
     *  Returns an array with all available campaigns
     *
     *  @return  array
     */
    public static function getCampaigns()
    {
        \JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_convertforms/models');

        $model = \JModelLegacy::getInstance('Campaigns', 'ConvertFormsModel', array('ignore_request' => true));
        $model->setState('filter.state', 1);

        return $model->getItems();
    }

    /**
     *  Logs messages to log file
     *
     *  @param   string  $msg   The message
     *  @param   object  $type  The log type
     *
     *  @return  void
     */
    public static function log($msg, $type = 'debug')
    {
        $debugIsEnabled = self::getComponentParams()->get('debug', false);

        if ($type == 'debug' && !$debugIsEnabled)
        {
            return;
        }

        $type = ($type == 'debug') ? \JLog::DEBUG : \JLog::ERROR;
        \JLog::add($msg, $type, 'com_convertforms');
    }

    /**
     *  Loads pre-made form template 
     *
     *  @param   string  $name  The template name
     *
     *  @return  object         
     */
    public static function loadFormTemplate($name)
    {
        $form = JPATH_ROOT . '/media/com_convertforms/templates/' . $name . '.cnvf';

        if (!\JFile::exists($form))
        {
            return;
        }

        $content = file_get_contents($form);

        if (empty($content))
        {
            return;
        }

        $item = json_decode($content, true);
        $item = $item[0];

        $data = (object) array_merge((array) $item, (array) json_decode($item['params']));
        $data->id = 0;
        $data->campaign = null;
        $data->fields = (array) $data->fields;

        return $data;
    }

    /**
     * Configure the Linkbar.
     *
     * @param   string  $vName  The name of the active view.
     *
     * @return  void
     */
    public static function addSubmenu($vName)
    {
        \JHtmlSidebar::addEntry(
            \JText::_('NR_DASHBOARD'),
            'index.php?option=com_convertforms',
            'convertforms'
        );
        \JHtmlSidebar::addEntry(
            \JText::_('COM_CONVERTFORMS_FORMS'),
            'index.php?option=com_convertforms&view=forms',
            'forms'
        );
        \JHtmlSidebar::addEntry(
            \JText::_('COM_CONVERTFORMS_CAMPAIGNS'),
            'index.php?option=com_convertforms&view=campaigns',
            'campaigns'
        );
        \JHtmlSidebar::addEntry(
            \JText::_('COM_CONVERTFORMS_CONVERSIONS'),
            'index.php?option=com_convertforms&view=conversions',
            'conversions'
        );
        \JHtmlSidebar::addEntry(
            \JText::_('COM_CONVERTFORMS_ADDONS'),
            'index.php?option=com_convertforms&view=addons',
            'addons'
        );
    }

    /**
     *  Returns permissions
     *
     *  @return  object
     */
    public static function getActions()
    {
        $user = \JFactory::getUser();
        $result = new \JObject;
        $assetName = 'com_convertforms';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action)
        {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }

    /**
     *  Returns a form object from database
     *
     *  @param   Integer  $id  The Form ID
     *
     *  @return  object       The Form object
     */
    public static function getForm($id)
    {
        if (!$id)
        {
            return;
        }

        // Get a db connection.
        $db = \JFactory::getDbo();
        $query = $db->getQuery(true);
         
        $query->select("*")
            ->from($db->quoteName('#__convertforms'))
            ->where($db->quoteName('id') . ' = '. $id)
            ->where($db->quoteName('state') . ' = 1');
         
        $db->setQuery($query);

        return $db->loadAssoc();
    }

    /**
     *  Prepares a form object for rendering
     *
     *  @param   Object  $form  The form object
     *
     *  @return  array          The prepared form array
     */
    public static function prepareForm($item)
    {
        if (!$item || !isset($item['params']))
        {
            return;
        }

        $item['id'] = isset($item['id']) ? $item['id'] : 0;
        $classPrefix = 'cf';

        // Replace variables
        $item["params"] = \ConvertForms\SmartTags::replace($item['params'], null, $item['id']);

        /* Decode Params */
        $params = new \JRegistry($item["params"]);
        $item["params"] = $params;

        /* Box Classes */
        $boxClasses = array(
            "convertforms",
            $classPrefix,
            $classPrefix . "-" . $params->get("imgposition"),
            $classPrefix . "-" . $params->get("formposition"),
            $params->get("hideform", true) ? $classPrefix . "-success-hideform" : null,
            $params->get("hidetext", false) ? $classPrefix . "-success-hidetext" : null,
            !$params->get("hidelabels", false) ? $classPrefix . "-hasLabels" : null,
            $params->get("centerform", false) ? $classPrefix . "-isCentered" : null,
            $params->get("classsuffix", null)
        );

        /* Box Styles */
        $font = trim($params->get('font'));

        $boxStyle = array(
            "max-width:"        . ($params->get("autowidth", "auto") == "auto" ? "auto" : (int) $params->get("width", "500") . "px"),
            "background-color:" . $params->get("bgcolor", "transparent"),
            "border-style:"     . $params->get("borderstyle", "solid"),
            "border-width:"     . (int) $params->get("borderwidth", "2") . "px",
            "border-color:"     . $params->get("bordercolor", "#000"),
            "border-radius:"    . (int) $params->get("borderradius", "0") . "px",
            "padding:"          . (int) $params->get("padding", "20") . "px",
            (!empty($font)) ? "font-family:" . $font : null
        );

        // Background Image
        if ($params->get("bgimage", false))
        {
            $imgurl = intval($params->get("bgimage")) == 1 ? \JURI::root() . $params->get("bgfile") : $params->get("bgurl");
            $bgImage = array(
                "background-image: url(". $imgurl .")",
                "background-repeat:"   . strtolower($params->get("bgrepeat")),
                "background-size:"     . strtolower($params->get("bgsize")),
                "background-position:" . strtolower($params->get("bgposition"))
            );

            $boxStyle = array_merge($bgImage, $boxStyle);
        }

        // Form HTML Attributes
        $item["boxattributes"] = implode(" ",
            array(
                'id="' . $classPrefix . '_' . $item["id"] . '"',
                'class="' . implode(" ", $boxClasses) . '"',
                'style="' . implode(";", $boxStyle) . '"'
            )
        );
   

        // Main Image Checks
        $imageOption = $params->get("image");
        if ($imageOption == '1')
        {
            if (\JFile::exists(JPATH_SITE . "/" . $params->get("imagefile")))
            {
                $item["image"] = \JURI::root() . $params->get("imagefile");
            }
        }
        if ($imageOption == '2')
        {
            $item["image"] = $params->get("imageurl");
        }

        // Image Container
        $item["imagecontainerclasses"] = implode(" ", array(
            (in_array($params->get("imgposition"), array("img-right", "img-left")) ? $classPrefix . "-col-medium-" . $params->get("imagesize", 6) : null),
        ));

        // Image
        $item["imagestyles"] = array(
            "width:" . ($params->get("imageautowidth", "auto") == "auto" ? "auto" : (int) $params->get("imagewidth", "500") . "px"),
            "left:". (int) $params->get("imagehposition", "0") . "px ",
            "top:". (int) $params->get("imagevposition", "0") . "px"
        );
        $item["imageclasses"] = array(
            ($params->get("hideimageonmobile", false) ? "cf-hide-mobile" : "")
        );

        // Form Container
        $item["formclasses"] = array(
            (in_array($params->get("formposition"), array("form-left", "form-right")) ? $classPrefix . "-col-large-" . $params->get("formsize", 6) : null),
        );
        $item["formstyles"] = array(
            "background-color:" . $params->get("formbgcolor", "none")
        );

        // Content
        $item["contentclasses"] = implode(" ", array(
            (in_array($params->get("formposition"), array("form-left", "form-right")) ? $classPrefix . "-col-large-" . (16 - $params->get("formsize", 6)) : null),
        ));

        // Text Container
        $item["textcontainerclasses"] = implode(" ", array(
            (in_array($params->get("imgposition"), array("img-right", "img-left")) ? $classPrefix . "-col-medium-" . (16 - $params->get("imagesize", 6)) : null),
        ));

        $textContent = trim($params->get("text", null));
        $footerContent = trim($params->get("footer", null));

        $item["textIsEmpty"]   = empty($textContent);
        $item["footerIsEmpty"] = empty($footerContent);
        $item["hascontent"]    = !$item["textIsEmpty"] || (bool) isset($item["image"]) ?  1 : 0;

        // Prepare Fields
        \ConvertForms\FieldsHelper::prepare($item);

        // Load custom fonts into the document
        \NRFramework\Fonts::loadFont($font);

        // Finalizing Item
        $item["styles"][] = $params->get("customcss");

        unset($item["params"]["fields"]);
        unset($item["params"]["customcss"]);

        return $item;
    }

    /**
     *  Renders form by ID
     *
     *  @param   integer  $id  The form ID
     *
     *  @return  string        The form HTML
     */
    public static function renderFormById($id)
    {
        if (!$data = self::getForm((int) $id))
        {
            return;
        }

        self::loadassets(true);

        return self::renderForm($data);
    }

    /**
     *  Renders Form
     *
     *  @param   integer  $formid  The form id
     *
     *  @return  string            The form HTML
     */
    public static function renderForm($data)
    {
        $data = self::prepareForm($data);
        $layout = new \JLayoutFile("form", null, array('debug' => 0, 'client' => 1, 'component' => 'com_convertforms'));
        return $layout->render($data);
    }

    /**
     *  Loads components media files
     *
     *  @param   boolean  $front
     *
     *  @return  void
     */
    public static function loadassets($frontend = false)
    {
        static $run;

        if ($run)
        {
            return;
        }

        $run = true;

        // Front-end media files
        if ($frontend)
        {
            $params = self::getComponentParams();

            if ($params->get("loadjQuery", true))
            {
                \JHtml::_('jquery.framework');
            }

            $mediaVersioning = $params->get("mediaversioning", true);
            \NRFramework\Functions::addMedia("convertforms.js", "com_convertforms", $mediaVersioning);

            if ($params->get("loadCSS", true))
            {
                \NRFramework\Functions::addMedia("convertforms.css", "com_convertforms", $mediaVersioning);
            }

            \JFactory::getDocument()->addScriptDeclaration('
                var ConvertFormsConfig = {
                    "baseurl" : "' . \JURI::root() . '",
                    "debug"   : ' . $params->get("debug", "false") . '
                };
            ');

            return;
        }

        \JHtml::_('jquery.framework');

        // Back-end Media Files
        \NRFramework\Functions::addMedia(array("convertforms.sys.js", "convertforms.sys.css"), "com_convertforms");

        $version = \NRFramework\Functions::getExtensionVersion("com_convertforms");

        // Make sure Novarain Fields CSS is loaded
        \JHtml::stylesheet('plg_system_nrframework/fields.css', false, true);
    }

    /**
     *  Get Campaign Item by ID
     *
     *  @param   integer  $id  The campaign ID
     *
     *  @return  object
     */
    public static function getCampaign($id)
    {
        $model = \JModelLegacy::getInstance('Campaign', 'ConvertFormsModel', array('ignore_request' => true));
        return $model->getItem($id);
    }
}