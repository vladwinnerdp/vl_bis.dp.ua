<?php
/**
 * @package	AcyMailing for Joomla!
 * @version	5.10.4
 * @author	acyba.com
 * @copyright	(C) 2009-2018 ACYBA S.A.R.L. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');
?><?php $acltype = acymailing_get('type.acl'); ?>
<div class="<?php echo acymailing_isAdmin() ? 'acyblockoptions' : 'onelineblockoptions'; ?>">
	<span class="acyblocktitle"><?php echo acymailing_translation('ACCESS_LEVEL'); ?></span>
	<table width="100%">
		<tr>
			<td valign="top" width="50%">
				<div class="acyblockoptions">
					<span class="acyblocktitle"><?php echo acymailing_translation('ACCESS_LEVEL_SUB'); ?></span>
					<?php $acltype->nonLoggedIn = true;
					echo $acltype->display('data[list][access_sub]', $this->list->access_sub); ?>
				</div>
			</td>
			<td valign="top">
				<div class="acyblockoptions">
					<span class="acyblocktitle"><?php echo acymailing_translation('ACCESS_LEVEL_MANAGE'); ?></span>
					<?php $acltype->nonLoggedIn = false;
					echo $acltype->display('data[list][access_manage]', $this->list->access_manage); ?>
				</div>
			</td>
		</tr>
	</table>
</div>
