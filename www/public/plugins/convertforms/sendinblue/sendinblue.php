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

class plgConvertFormsSendinBlue extends \ConvertForms\Plugin
{
	/**
	 *  Main method to store data to service
	 *
	 *  @return  void
	 */
	public function subscribe()
	{
		$api = new NR_SendinBlue(array('api' => $this->lead->campaign->api));
		$api->subscribe(
			$this->lead->email,
			$this->lead->params,
			$this->lead->campaign->list
		);
		
		if (!$api->success())
		{
			throw new Exception($api->getLastError());
		}
	}
}