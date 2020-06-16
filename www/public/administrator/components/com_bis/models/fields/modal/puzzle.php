<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Language\LanguageHelper;

/**
 * Supports a modal article picker.
 *
 * @since  1.6
 */
class JFormFieldModal_Puzzle extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $type = 'Modal_Puzzle';

	/**
	 * Method to get the field input markup.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   1.6
	 */
	protected function getInput()
	{

        $allowClear     = ((string) $this->element['clear'] != 'false');
        $allowSelect    = ((string) $this->element['select'] != 'false');

        // The active article id field.
        $value = (int) $this->value > 0 ? (int) $this->value : '';

        // Create the modal id.
        $modalId = 'Puzzle_' . $this->id;

        // Add the modal field script to the document head.
        JHtml::_('jquery.framework');
        JHtml::_('script', 'system/modal-fields.js', array('version' => 'auto', 'relative' => true));

        // Script to proxy the select modal function to the modal-fields.js file.
        if ($allowSelect)
        {
            static $scriptSelect = null;

            if (is_null($scriptSelect))
            {
                $scriptSelect = array();
            }

            if (!isset($scriptSelect[$this->id]))
            {
                JFactory::getDocument()->addScriptDeclaration("
		            function jSelectPuzzle_" . $this->id . "(id, name) {
			        window.processModalSelect('Puzzle', '" . $this->id . "', id, name);
		}
		");

                JText::script('JGLOBAL_ASSOCIATIONS_PROPAGATE_FAILED');

                $scriptSelect[$this->id] = true;
            }
        }

        $modalTitle    = JText::_('COM_CONTENT_CHANGE_ARTICLE');

        if ($value)
        {
            $db    = JFactory::getDbo();
            $query = $db->getQuery(true)
                ->select($db->quoteName('name'))
                ->from($db->quoteName('#__pl_events'))
                ->where($db->quoteName('id') . ' = ' . (int) $value);
            $db->setQuery($query);

            try
            {
                $title = $db->loadResult();
            }
            catch (RuntimeException $e)
            {
                JError::raiseWarning(500, $e->getMessage());
            }
        }

        $title = empty($title) ? JText::_('COM_CONTENT_SELECT_AN_ARTICLE') : htmlspecialchars($title, ENT_QUOTES, 'UTF-8');

        // The current article display field.
        $html  = '<span class="input-append">';
        $html .= '<input class="input-medium" id="' . $this->id . '_name" type="text" value="' . $title . '" disabled="disabled" size="35" />';

        // Select article button
        if ($allowSelect)
        {
            $html .= '<a'
                . ' class="btn hasTooltip' . ($value ? ' hidden' : '') . '"'
                . ' id="' . $this->id . '_select"'
                . ' data-toggle="modal"'
                . ' role="button"'
                . ' href="#ModalSelect' . $modalId . '"'
                . ' title="' . JHtml::tooltipText('COM_CONTENT_CHANGE_ARTICLE') . '">'
                . '<span class="icon-file" aria-hidden="true"></span> ' . JText::_('JSELECT')
                . '</a>';
        }

        // Clear article button
        if ($allowClear)
        {
            $html .= '<a'
                . ' class="btn' . ($value ? '' : ' hidden') . '"'
                . ' id="' . $this->id . '_clear"'
                . ' href="#"'
                . ' onclick="window.processModalParent(\'' . $this->id . '\'); return false;">'
                . '<span class="icon-remove" aria-hidden="true"></span>' . JText::_('JCLEAR')
                . '</a>';
        }

        $html .= '</span>';

        // Setup variables for display.
        $linkArticles = 'index.php?option=com_bis&amp;view=events&amp;layout=modal&amp;tmpl=component&amp;' . JSession::getFormToken() . '=1';
        //$linkArticles = 'index.php?option=com_content&amp;view=articles&amp;layout=modal&amp;tmpl=component&amp;' . JSession::getFormToken() . '=1';


        $urlSelect = $linkArticles . '&amp;function=jSelectPuzzle_' . $this->id;
        // Select article modal
        if ($allowSelect)
        {
            $html .= JHtml::_(
                'bootstrap.renderModal',
                'ModalSelect' . $modalId,
                array(
                    'title'       => $modalTitle,
                    'url'         => $urlSelect,
                    'height'      => '400px',
                    'width'       => '800px',
                    'bodyHeight'  => '70',
                    'modalWidth'  => '80',
                    'footer'      => '<a role="button" class="btn" data-dismiss="modal" aria-hidden="true">' . JText::_('JLIB_HTML_BEHAVIOR_CLOSE') . '</a>',
                )
            );
        }



        // Note: class='required' for client side validation.
        $class = $this->required ? ' class="required modal-value"' : '';

        $html .= '<input type="hidden" id="' . $this->id . '_id" ' . $class . ' data-required="' . (int) $this->required . '" name="' . $this->name
            . '" data-text="' . htmlspecialchars(JText::_('COM_CONTENT_SELECT_AN_ARTICLE', true), ENT_COMPAT, 'UTF-8') . '" value="' . $value . '" />';

        return $html;

	}
}
