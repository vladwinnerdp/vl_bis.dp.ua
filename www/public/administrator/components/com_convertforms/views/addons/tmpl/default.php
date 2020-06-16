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
JHtml::_('bootstrap.popover');

?>

<div class="row-fluid">
    <div id="j-sidebar-container" class="span2">
        <?php echo $this->sidebar; ?>
    </div>
    <div id="j-main-container">
        
        <?php if (!NRFramework\Functions::getDownloadKey()) { ?>
            <div class="alert alert-danger">
                <h3><?php echo JText::_("NR_DOWNLOAD_KEY_MISSING") ?></h3>
                <p><?php echo JText::sprintf("COM_CONVERTFORMS_ADDONS_MISSING_KEY"); ?>

                <a style="position:relative; top:-2px; left:5px;" class="btn btn-small btn-success" href="<?php echo JURI::base() ?>index.php?option=com_plugins&view=plugins&filter_search=novarain">
                    <?php echo JText::_("NR_DOWNLOAD_KEY_UPDATE")?>
                </a>
            </div>
        <?php } ?>
        
        <div class="cf-addons-container">
            <h2>
                <?php echo JText::_("COM_CONVERTFORMS") ?>
                <?php echo JText::_("COM_CONVERTFORMS_ADDONS") ?>
            </h2>
            <p><?php echo JText::_("COM_CONVERTFORMS_ADDONS_DESC") ?></p>
            <div class="cf-addons">
                <?php foreach ($this->availableAddons as $key => $item) { ?>
                    <div class="cf-addon">
                        <div class="cf-addon-wrap">
                            <div class="cf-addon-img">
                                <img alt="<?php echo $item["label"]; ?>" src="<?php echo $item["image"]; ?>"/>
                            </div>
                            <div class="cf-addon-text">
                                <h3><?php echo $item["label"]; ?></h3>
                                <?php echo $item["description"]; ?>
                            </div>
                            <div class="cf-addon-action text-center">

                                <?php if ($item["comingsoon"]) { ?>
                                    Coming Soon
                                <?php } else { ?>

                                    
                                    <?php if ($item["extensionid"]) { ?>
                                        <a class="cf-addon-btn btn btn-success" href="<?php echo $item["backendurl"] ?>">
                                            <span class="icon-checkmark"></span>
                                            Installed
                                        </a>
                                    <?php } ?>

                                    <?php if (isset($item["docalias"])) { ?>
                                        <a class="cf-addon-btn btn" href="http://www.tassos.gr/joomla-extensions/convert-forms//docs/<?php echo $item["docalias"]; ?>" target="_blank">
                                            <?php echo JText::_("NR_DOCUMENTATION"); ?>
                                        </a>
                                    <?php } ?>
                                   
                                    
                                    

                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="cf-addon">
                    <div class="cf-addon-wrap">
                        <div class="cf-addon-img">
                            <a target="_blank" target="_blank" href="https://www.tassos.gr/contact">
                                <img alt="<?php echo $item["description"]; ?>" src="http://static.tassos.gr/images/integrations/addon.png"/>
                            </a>
                        </div>
                        <div class="cf-addon-text">
                            <h3><?php echo JText::_("COM_CONVERTFORMS_ADDONS_MISSING_ADDON") ?></h3>
                            <?php echo JText::_("COM_CONVERTFORMS_ADDONS_MISSING_ADDON_DESC") ?>
                        </div>
                        <div class="cf-addon-action text-center">
                            <a class="btn btn-primary" target="_blank" href="https://www.tassos.gr/contact"><?php echo JText::_("NR_CONTACT_US")?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once(JPATH_COMPONENT_ADMINISTRATOR."/layouts/footer.php"); ?>
