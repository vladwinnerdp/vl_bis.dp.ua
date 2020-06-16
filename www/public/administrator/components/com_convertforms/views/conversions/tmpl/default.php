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

JHtml::_('formbehavior.chosen', 'select');

$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
$user      = JFactory::getUser();
$columns   = $this->state->get('filter.columns');

if (is_null($columns) || (is_array($columns) && count(array_filter($columns)) == 0))
{
    $columns = $this->getModel()->default_columns;
}

?>

<form action="<?php echo JRoute::_('index.php?option=com_convertforms&view=conversions'); ?>" class="clearfix" method="post" name="adminForm" id="adminForm">
    <?php if (!empty($this->sidebar)) : ?>
        <div id="j-sidebar-container" class="span2">
            <?php echo $this->sidebar; ?>
        </div>
        <div id="j-main-container" class="span10">
    <?php else : ?>
        <div id="j-main-container">
    <?php endif;?>

    <?php
        echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
    ?>

    <table class="adminlist nrTable table">
        <thead>
            <tr>
                <th width="2%" class="center"><?php echo JHtml::_('grid.checkall'); ?></th>
                <th width="3%" class="nowrap hidden-phone" align="center">
                    <?php echo JHtml::_('searchtools.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder); ?>
                </th>
                <?php foreach ($columns as $key => $column) { ?>
                    <th class="nowrap col_<?php echo $column; ?>">
                        <?php 
                            $isParam = (strpos($column, 'param_') !== false);

                            $columnLabel = $isParam ? ucfirst(str_replace('param_', '', $column)) : 'COM_CONVERTFORMS_' . strtoupper($column);
                            echo JHtml::_('searchtools.sort', $columnLabel, 'a.' . $column, $listDirn, $listOrder); 
                        ?>
                    </th>                            
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php if (count($this->items)) { ?>
                <?php foreach($this->items as $i => $item): ?>
                    <?php 
                        $canChange  = $user->authorise('core.edit.state', 'com_convertforms.conversion.' . $item->id);
                    ?>
                    <tr class="row<?php echo $i % 2; ?> <?php echo isset($item->params->sync_error) ? "error" : "" ?>">
                        <td class="center"><?php echo JHtml::_('grid.id', $i, $item->id); ?></td>
                        <td class="center">
                            <div class="btn-group">
                                <?php 
                                    echo JHtml::_('jgrid.published', $item->state, $i, 'conversions.', $canChange); 
                               
                                    if ($canChange)
                                    {
                                        JHtml::_('actionsdropdown.' . ((int) $item->state === -2 ? 'un' : '') . 'trash', 'cb' . $i, 'conversions');
                                        echo JHtml::_('actionsdropdown.render', $this->escape($item->id));
                                    }
                                ?>
                            </div>
                        </td>
                        <?php foreach ($columns as $key => $column) { 
                                // Convert to lower case to always match the field in case it has been renamed.
                                $column = strtolower($column);
                                $params = [];

                                foreach ($item->params as $key => $value)
                                {
                                    $params[strtolower($key)] = $value;
                                }

                                $isParam = (strpos($column, 'param_') !== false);
                                $columnName = $isParam ? str_replace('param_', '' , $column) : $column;
                                $value = false;
                                $col_class = !$isParam ? 'nowrap col_' . $column : $column;

                            ?>
                            <td class="<?php echo $col_class; ?>">
                                <?php 
                                    switch ($columnName)
                                    {
                                        case 'user_username':
                                            if ($user = JFactory::getUser($item->user_id))
                                            {
                                                $url = JURI::base() . '/index.php?option=com_users&task=user.edit&id=' . $user->id;
                                                $value = '<a href="' . $url . '">' . $user->username . '</a>';
                                            }
                                            break;
                                        case 'user_id':
                                            $value = '';

                                            if ($item->user_id > 0)
                                            {
                                                $url = JURI::base() . '/index.php?option=com_users&task=user.edit&id=' . $user->id;
                                                $value = '<a href="' . $url . '">' . $user->id . '</a>';       
                                            }
                                            break;

                                        default:
                                            if ($isParam)
                                            {
                                                if (isset($params[$columnName]))
                                                {
                                                    $value = $params[$columnName];
                                                }
                                            } else 
                                            {
                                                if (isset($item->$columnName))
                                                {
                                                    $value = $item->$columnName;
                                                }
                                            }
                                            break;
                                    }

                                    if (is_array($value))
                                    {
                                        $value = implode(',', $value);
                                    }
                                ?>

                                <?php echo $value; ?>

                                <?php if (isset($item->params->sync_service) && isset($item->params->sync_error) && $key == 0) { ?>
                                    <span class="hasPopover icon icon-info" 
                                        data-placement="top"
                                        data-title="<?php echo JText::_("PLG_CONVERTFORMS_" . $item->params->sync_service . "_ALIAS"); ?>"
                                        data-content="<?php echo $item->params->sync_error ?>"
                                        style="color:red;">
                                    </span>
                                <?php } ?>
                            </td>                            
                        <?php } ?>
                    </tr>
                <?php endforeach; ?>  
            <?php } else { ?>
                <tr>
                    <td align="center" colspan="<?php echo count($columns) + 2 ?>">
                        <div align="center">
                            <?php echo ConvertForms\Helper::noItemsFound(); ?>
                        </div>
                    </td>
                </tr>
            <?php } ?>  
        </tbody>
        <tfoot>
			<tr><td colspan="<?php echo count($columns) + 2 ?>"><?php echo $this->pagination->getListFooter(); ?></td></tr>
        </tfoot>
    </table>
    <div>
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
    </div>
</form>
<?php include_once(JPATH_COMPONENT_ADMINISTRATOR . '/layouts/footer.php'); ?>
