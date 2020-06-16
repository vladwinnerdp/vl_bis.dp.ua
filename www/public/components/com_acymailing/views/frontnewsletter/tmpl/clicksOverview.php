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
if(acymailing_getVar('cmd', 'tmpl', '') == 'component'){
?>
<style type="text/css">
	body.contentpane{
		padding-left: 0px;
    	padding-right: 0px;
	}
</style>
<?php
}
?>
<div id="acy_content">
	<div id="iframedoc"></div>
	<div class="onelineblockoptions" style="margin-top: 0px;" width="100%" id="clicks_overview">
		<?php
		if(empty($this->stats)) {
			echo acymailing_translation('ACY_NO_STATISTICS');
		}else{
			echo $this->mail->body;
		} ?>
	</div>
</div>
