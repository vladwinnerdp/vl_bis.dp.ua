<?php

/**
 * @author          Tassos Marinos <info@tassos.gr>
 * @link            http://www.tassos.gr
 * @copyright       Copyright © 2018 Tassos Marinos All Rights Reserved
 * @license         GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
*/

namespace NRFramework;

// No direct access
defined('_JEXEC') or die;

use NRFramework\Cache;

class HTML
{
	/**
	 * Renders Pro Button
	 *
	 * @param string $feature_label  The text that will be used as the modal popup feature
	 *
	 * @return void
	 */
	public static function renderProButton($feature_label = null)
	{
		include_once JPATH_PLUGINS . '/system/nrframework/fields/pro.php';

        $field   = new \JFormFieldNR_PRO;
        $element = new \SimpleXMLElement('
			<field name="pro" type="nr_pro"
				label="' . $feature_label . '"
            />');

        $field->setup($element, null);

        echo $field->__get('input');
	}

    /**
     *  Renders a modal that will be shown on Pro only features
     *
     *  @return   void
     */
    public static function renderProOnlyModal()
    {
		$hash = 'proOnlyModal';

		// Render modal once
		if (Cache::get($hash))
		{
			return;
		}

		$options = [
			'extension_name' => Extension::getExtensionNameByRequest(true),
			'upgrade_url'    => Extension::getTassosExtensionUpgradeURL()
		];

		$layout = new \JLayoutFile('proonlymodal', dirname(__DIR__) . '/layouts');
		$html = $layout->render($options);

		echo \JHtml::_('bootstrap.renderModal', 'proOnlyModal', ['backdrop' => 'static'], $html);

		Cache::set($hash, true);
    }

	public static function smartTagsBox($options = array())
	{
		include_once JPATH_PLUGINS . '/system/nrframework/fields/smarttagsbox.php';

		$field   = new \JFormFieldSmartTagsBox;
		$element = new \SimpleXMLElement('<field name="pro" type="SmartTagsBox"/>');
		
		$field->setup($element, null);

		return $field->__get('input');
	}

	/**
	 * Construct the HTML for the input field in a tree
	 * Logic from administrator\components\com_modules\views\module\tmpl\edit_assignment.php
	 */
	public static function treeselect(&$options, $name, $value, $id, $size = 300, $simple = 0)
	{
		Functions::loadLanguage('com_menus', JPATH_ADMINISTRATOR);
		Functions::loadLanguage('com_modules', JPATH_ADMINISTRATOR);

		if (empty($options))
		{
			return '<fieldset class="radio">' . \JText::_('NR_NO_ITEMS_FOUND') . '</fieldset>';
		}

		if (!is_array($value))
		{
			$value = explode(',', $value);
		}

		$count = 0;
		if ($options != -1)
		{
			foreach ($options as $option)
			{
				$count++;
				if (isset($option->links))
				{
					$count += count($option->links);
				}
			}
		}

		if ($options == -1)
		{
			if (is_array($value))
			{
				$value = implode(',', $value);
			}
			if (!$value)
			{
				$input = '<textarea name="' . $name . '" id="' . $id . '" cols="40" rows="5">' . $value . '</textarea>';
			}
			else
			{
				$input = '<input type="text" name="' . $name . '" id="' . $id . '" value="' . $value . '" size="60">';
			}

			return '<fieldset class="radio"><label for="' . $id . '">' . \JText::_('NR_ITEM_IDS') . ':</label>' . $input . '</fieldset>';
		}

		if ($simple)
		{
			$attr = 'style="width: ' . $size . 'px" multiple="multiple"';

			$html = \JHtml::_('select.genericlist', $options, $name, trim($attr), 'value', 'text', $value, $id);

			return $html;
		}

		Functions::addMedia(array(
			"treeselect.js", 
			"treeselect.css"
		));

		$html = array();

		$html[] = '<div class="nr_treeselect" id="' . $id . '">';
		$html[] = '
			<div class="form-inline nr_treeselect-controls">

				<span class="nr_treeselect_control">' . \JText::_('JSELECT') . ':
					<a class="nr_treeselect-checkall" href="javascript:;">' . \JText::_('JALL') . '</a>,
					<a class="nr_treeselect-uncheckall" href="javascript:;">' . \JText::_('JNONE') . '</a>,
					<a class="nr_treeselect-toggleall" href="javascript:;">' . \JText::_('NR_TOGGLE') . '</a>
				</span>
				
				<span class="nr_treeselect_control">' . \JText::_('NR_EXPAND') . ':
					<a class="nr_treeselect-expandall" href="javascript:;">' . \JText::_('JALL') . '</a>,
					<a class="nr_treeselect-collapseall" href="javascript:;">' . \JText::_('JNONE') . '</a>
				</span>
				
				<span class="nr_treeselect_control">' . \JText::_('JSHOW') . ':
					<a class="nr_treeselect-showall" href="javascript:;">' . \JText::_('JALL') . '</a>,
					<a class="nr_treeselect-showselected" href="javascript:;">' . \JText::_('NR_SELECTED') . '</a>
				</span>

				<span class="nr_treeselect_control nr_no_border">
					<a class="nr_treeselect-maximize" href="javascript:;">' . \JText::_('NR_MAXIMIZE') . '</a>
					<a class="nr_treeselect-minimize" style="display:none;" href="javascript:;">' . \JText::_('NR_MINIMIZE') . '</a>
				</span>

				<span class="nr_treeselect_control nr_treeselect-filter right">
					<input type="text" name="nr_treeselect-filter" class="search-query nr_treeselect-filter" size="16"
					autocomplete="off" placeholder="' . \JText::_('JSEARCH_FILTER') . '" aria-invalid="false" tabindex="-1">
				</span>
			</div>';

		$o = array();
		foreach ($options as $option)
		{
			$option->level = isset($option->level) ? $option->level : 0;
			$o[]           = $option;
			if (isset($option->links))
			{
				foreach ($option->links as $link)
				{
					$link->level = $option->level + (isset($link->level) ? $link->level : 1);
					$o[]         = $link;
				}
			}
		}

		$html[]    = '<ul class="nr_treeselect-ul" style="max-height:300px;min-width:' . $size . 'px;overflow-x: hidden;">';
		$prevlevel = 0;

		foreach ($o as $i => $option)
		{
			if ($prevlevel < $option->level)
			{
				// correct wrong level indentations
				$option->level = $prevlevel + 1;

				$html[] = '<ul class="nr_treeselect-sub">';
			}
			else if ($prevlevel > $option->level)
			{
				$html[] = str_repeat('</li></ul>', $prevlevel - $option->level);
			}
			else if ($i)
			{
				$html[] = '</li>';
			}

			$labelclass = trim('pull-left ' . (isset($option->labelclass) ? $option->labelclass : ''));

			$html[] = '<li>';

			$item = '<div class="' . trim('nr_treeselect-item pull-left ' . (isset($option->class) ? $option->class : '')) . '">';
			if (isset($option->title))
			{
				$labelclass .= ' nav-header';
			}

			if (isset($option->title) && (!isset($option->value) || !$option->value))
			{
				$item .= '<label class="' . $labelclass . '">' . $option->title . '</label>';
			}
			else
			{
				$selected = in_array($option->value, $value) ? ' checked="checked"' : '';
				$disabled = (isset($option->disable) && $option->disable) ? ' readonly="readonly" style="visibility:hidden"' : '';

				$item .= '<input type="checkbox" class="pull-left" name="' . $name . '" id="' . $id . $option->value . '" value="' . $option->value . '"' . $selected . $disabled . '>
					<label for="' . $id . $option->value . '" class="' . $labelclass . '">' . $option->text . '</label>';
			}
			$item .= '</div>';
			$html[] = $item;

			if (!isset($o[$i + 1]) && $option->level > 0)
			{
				$html[] = str_repeat('</li></ul>', (int) $option->level);
			}
			$prevlevel = $option->level;
		}
		$html[] = '</ul>';
		$html[] = '
			<div style="display:none;" class="nr_treeselect-menu-block">
				<div class="pull-left nav-hover nr_treeselect-menu">
					<div class="btn-group">
						<a href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-secondary">
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li class="nav-header">' . \JText::_('COM_MODULES_SUBITEMS') . '</li>
							<li class="divider"></li>
							<li>
								<a class="checkall" href="javascript:;">
									<span class="icon-checkbox"></span> 
									' . \JText::_('JSELECT') . '
								</a>
							</li>
							<li>
								<a class="uncheckall" href="javascript:;">
									<span class="icon-checkbox-unchecked"></span>
									' . \JText::_('COM_MODULES_DESELECT') . '
								</a>
							</li>
							<div class="nr_treeselect-menu-expand">
								<li class="divider"></li>
								<li><a class="expandall" href="javascript:;"><span class="icon-plus"></span> ' . \JText::_('NR_EXPAND') . '</a></li>
								<li><a class="collapseall" href="javascript:;"><span class="icon-minus"></span> ' . \JText::_('NR_COLLAPSE') . '</a></li>
							</div>
						</ul>
					</div>
				</div>
			</div>';
		$html[] = '</div>';

		$html = implode('', $html);
		return $html;
	}

	public static function treeselectSimple(&$options, $name, $value, $id, $size = 300)
	{
		return self::treeselect($options, $name, $value, $id, $size, 1);
	}
}