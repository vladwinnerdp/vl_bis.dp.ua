<?php
/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2016 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined ('_JEXEC') or die ('Restricted access');

class SppagebuilderAddonLink extends SppagebuilderAddons {

	public function render() {
		
	    $app = JFactory::getApplication();	    

		$class = (isset($this->addon->settings->class) && $this->addon->settings->class) ? $this->addon->settings->class : '';
		$link = (isset($this->addon->settings->link) && $this->addon->settings->link) ? $this->addon->settings->link : '';
		
        $subid = $app->input->get('subid',0, 'INT');
        $email = $app->input->get('email',0, 'STRING');
		
		$output = '';
		
		if ($subid && $email) {
			$output  = '<div class="sppb-addon sppb-addon-text-block ' . $class . '">';		
			$output .= '<div class="sppb-addon-content">';
			$output .= '<div class="btn-wrapper"><a href="'.$link.'?subid='.$subid.'&email='.$email.'">Урок освоил! Готов к тестированию!</a></div>';
			$output .= '</div>';
			$output .= '</div>';
		}		

		return $output;

	}		
}
