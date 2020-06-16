<?php
/**
 * @package	AcyMailing for Joomla!
 * @version	5.10.4
 * @author	acyba.com
 * @copyright	(C) 2009-2018 ACYBA S.A.R.L. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');
?><?php
include(ACYMAILING_BACK.'views'.DS.'tag'.DS.'view.html.php');

class FronttagViewFronttag extends TagViewTag
{

	function display($tpl = null)
	{
		acymailing_addStyle(false, ACYMAILING_CSS.'frontendedition.css?v='.filemtime(ACYMAILING_MEDIA.'css'.DS.'frontendedition.css'));

		parent::display($tpl);
	}

}
