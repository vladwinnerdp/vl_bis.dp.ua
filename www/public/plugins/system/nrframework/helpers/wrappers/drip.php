<?php

/**
 * @author          Tassos Marinos <info@tassos.gr>
 * @link            http://www.tassos.gr
 * @copyright       Copyright © 2018 Tassos Marinos All Rights Reserved
 * @license         GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
 */

// No direct access
defined('_JEXEC') or die;

require_once __DIR__ . '/wrapper.php';

class NR_Drip extends NR_Wrapper
{
	/**
	 * Create a new instance
	 * 
	 * @param string $key Your Drip API key
	 */
	public function __construct($key)
	{
		parent::__construct();
		$this->setKey($key);
		$this->setEndpoint('http://api.getdrip.com/v2');
		$this->options->set('headers.Accept', 'application/vnd.api+json');
		$this->options->set('headers.Content-Type', 'application/vnd.api+json');
		$this->options->set('headers.Authorization', 'Bearer ' . $this->key);
	}
}
