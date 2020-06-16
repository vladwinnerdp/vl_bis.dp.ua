<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_CREDITFORM
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

JHtml::_('formbehavior.chosen', 'select');


$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
$saveOrder = $listOrder == 'a.id';
if ($saveOrder)
{
    $saveOrderingUrl = 'index.php?option=com_bis&task=events.saveOrderAjax&tmpl=component';
    JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}

?>

<form action="index.php?option=com_bis&view=events" method="post" id="adminForm" name="adminForm">
    <?php echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this)); ?>
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th width="1%">
                <?php //echo JText::_('COM_BIS_USERS_NUM'); ?>
                <?php echo JHtml::_('searchtools.sort', 'COM_BIS_EVENTS_EVENT_ID', 'a.id', $listDirn, $listOrder, null, 'desc'); ?>
            </th>
            <th width="2%">
                <?php echo JText::_('COM_BIS_EVENT_NAME'); ?>
            </th>
            <th width="3%">
                <?php echo JText::_('COM_BIS_EVENT_PUBLISHED') ;?>
            </th>
            <th width="3%">
                <?php echo JText::_('COM_BIS_PRODUCTS_CREATED'); ?>
            </th>
            <th width="3%">
                <?php echo JText::_('COM_BIS_PRODUCTS_MODIFIED'); ?>
            </th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="4">
                <?php echo $this->pagination->getListFooter(); ?>
            </td>
            <td colspan="4">
                <?php echo $this->pagination->getResultsCounter(); ?>
            </td>
        </tr>
        </tfoot>
        <tbody>
        <?php if (!empty($this->items)) : ?>
            <?php foreach ($this->items as $i => $row) :
                    $link = JRoute::_('index.php?option=com_bis&task=event.edit&id=' . $row->id);
                ?>

                <tr>
                    <td><?php echo $row->id ?></td>
                    <td>
                        <a href="<?php echo $link; ?>" title="<?php echo JText::_('COM_BIS_EVENTS_EDIT_EVENT'); ?>"><?php echo $row->name; ?></a>
                    </td>
                    <td align="center"><?php echo $row->published ?></td>
                    <td align="center">
                        <?php echo $row->created; ?>
                    </td>
                    <td align="center">
                        <?php echo $row->modified; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>

    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="boxchecked" value="0"/>


    <?php echo JHtml::_('form.token'); ?>
</form>
<script>
    jQuery(function($) {
        $('.js-stools-btn-clear').on('click', function() {
            $('input[name="task"]').val('');
        });
    });
</script>
