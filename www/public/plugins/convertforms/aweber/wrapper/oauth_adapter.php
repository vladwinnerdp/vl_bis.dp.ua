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

// No direct access
defined('_JEXEC') or die('Restricted access');

interface AWeberOAuthAdapter
{
	public function request($method, $uri, $data = array());
	public function getRequestToken($callbackUrl = false);
}

?>
