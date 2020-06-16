<?php

/**
 * @package         Engage Box
 * @version         3.4.8 Pro
 * 
 * @author          Tassos Marinos <info@tassos.gr>
 * @link            http://www.tassos.gr
 * @copyright       Copyright © 2016 Tassos Marinos All Rights Reserved
 * @license         GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
*/

defined('_JEXEC') or die('Restricted access');

class plgEngageBoxSmartTags extends JPlugin
{
    /**
     *  Replaces Smart Tags in a string
     *
     *  @param   string  &$box  The box object
     *
     *  @return  void
     */
	public function onEngageBoxAfterRender(&$box)
	{
    	if (!$box)
        {
            return;
        }

        $tags = new NRFramework\SmartTags();
        $box = $tags->replace($box);
	}
}