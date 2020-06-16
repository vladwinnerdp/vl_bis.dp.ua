<?php

/**
 * @author          Tassos.gr
 * @link            http://www.tassos.gr
 * @copyright       Copyright © 2018 Tassos Marinos All Rights Reserved
 * @license         GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
*/

namespace NRFramework\Assignments;

defined('_JEXEC') or die;

use NRFramework\Assignment;
use NRFramework\WebClient;

class Browser extends Assignment
{
    /**
	 *  Returns the assignment's value
	 * 
	 *  @return string Browser name
	 */
	public function value()
	{
        return WebClient::getBrowser()['name'];
    }
}
