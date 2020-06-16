<?php

// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('jquery.framework');
$doc = JFactory::getDocument();
$doc->addStyleSheet(JUri::root(true) . '/templates/shaper_helix3/imgareaselect/css/imgareaselect-default.css');
$doc->addScript(JUri::root(true) . '/templates/shaper_helix3/imgareaselect/scripts/jquery.imgareaselect.pack.js');
$data = $this->form->getFieldset();
$presets = array();
?>
<style>
	select {width: 100% !important;}
</style>
<form action="<?php echo JRoute::_('index.php?option=com_bis&layout=edit&id=' . (int) $this->item->id); ?>"
      method="post" name="adminForm" id="adminForm">
    <div class="form-horizontal">
        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_BIS_EVENTS_EVENT_DETAILS'); ?></legend>
            <div class="row-fluid">
                <div class="span6">
					<?php foreach ($this->form->getFieldset() as $field): ?>
                        <?php
                        $dataShowOn = '';
                        $groupClass = $field->type === 'Spacer' ? ' field-spacer' : '';
                        ?>
                        <?php if ($field->showon) : ?>
                            <?php JHtml::_('jquery.framework'); ?>
                            <?php JHtml::_('script', 'jui/cms.js', array('version' => 'auto', 'relative' => true)); ?>
                            <?php $dataShowOn = ' data-showon=\'' . json_encode(JFormHelper::parseShowOnConditions($field->showon, $field->formControl, $field->group)) . '\''; ?>
                        <?php endif; ?>
                        <div class="control-group"<?php echo $dataShowOn; ?>>
                            <div class="control-label"><?php echo $field->label; ?></div>
                            <div class="controls"><?php echo $field->input; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </fieldset>
    </div>
    <input type="hidden" name="task" value="product.edit" />

<?php echo JHtml::_('form.token'); ?>