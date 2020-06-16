<?php

defined('_JEXEC') or die;

JLoader::import('joomla.plugin.plugin');
JLoader::import('pl_lib.library');

class PlgSystemLimitedAccess extends JPlugin
{
    // Plugin info constants
    const TYPE = 'system';
    const NAME = 'limitedaccess';

    private $pathPlugin = null;

    private $plugin;

    public $params;

    private $componentsEnabled = array('*');

    private $viewsEnabled 		= array('*');
    
    private $frontendEnabled 	= true;

    private $backendEnabled 	= false;

    function __construct( &$subject )
    {
        parent::__construct($subject);

        // Load plugin parameters
        $this->plugin = JPluginHelper::getPlugin(self::TYPE, self::NAME);
        $this->params = new JRegistry($this->plugin->params);

        // Init folder structure
        $this->initFolders();

    }

    public function onContentPrepareForm($form, $data)
    {
        // Check we have a form
        if (!($form instanceof JForm)) {
            $this->_subject->setError('JERROR_NOT_A_FORM');

            return false;
        }

        // Extra parameters for menu edit
        if ($form->getName() == 'com_menus.item') {
            $form->loadFile($this->pathPlugin . '/forms/menuitem.xml');
        }

        return true;
    }

    private function initFolders()
    {
        // Path
        $this->pathPlugin = JPATH_PLUGINS . '/' . self::TYPE . '/' . self::NAME;

        // Url
        $this->urlPlugin = JURI::root(true) . "/plugins/" . self::TYPE . "/" . self::NAME;
    }

    function onBeforeCompileHead()
    {
        if (!$this->validateUrl())
        {
            return true;
        }

        $app        = JFactory::getApplication();

        $pageParams = $app->getParams();

        $redirect = $pageParams->get('limitedaccess', 0);
		if ($redirect) {
		
			$subid = $app->input->get('subid',0,'INT');
			$email = $app->input->get('email','','STRING');
			
			if (!$subid || !$email) {
				JError::raiseError(404, JText::_("Page Not Found"));
				return false;
			}
			
			$valid = PlLibHelperEvents::getInstance()->checkSubid($subid, $email);
			
			if (!$valid) {
				JError::raiseError(404, JText::_("Page Not Found"));
				return false;
			}
		}
		
    }

    /**
     * validate if the plugin is enabled for current application (frontend / backend)
     *
     * @return boolean
     */
    private function validateApplication()
    {
        $app = JFactory::getApplication();

        if ( ($app->isSite() && $this->frontendEnabled) || ($app->isAdmin() && $this->backendEnabled) )
        {
            return true;
        }

        return false;
    }

    /**
     * Validate option in url
     *
     * @return boolean
     */
    private function validateComponent()
    {
        $option = JFactory::getApplication()->input->get('option');

        if ( in_array('*', $this->componentsEnabled) || in_array($option, $this->componentsEnabled) )
        {
            return true;
        }

        return false;
    }

    /**
     * Custom method for extra validations
     *
     * @return true
     */
    private function validateExtra()
    {
        return $this->validateApplication();
    }

    /**
     * Is the plugin enabled for this url?
     *
     * @return boolean
     */
    private function validateUrl()
    {
        if ( $this->validateComponent() && $this->validateView())
        {
            if (method_exists($this, 'validateExtra'))
            {
                return $this->validateExtra();
            }
            else
            {
                return true;
            }
        }

        return false;
    }

    /**
     * validate view parameter in url
     *
     * @return boolean
     */
    private function validateView()
    {
        $view = JFactory::getApplication()->input->get('view');

        if ( in_array('*', $this->viewsEnabled) || in_array($view, $this->viewsEnabled))
        {
            return true;
        }

        return false;
    }
}