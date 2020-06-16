<?php

/**
 * @author          Tassos.gr <info@tassos.gr>
 * @link            http://www.tassos.gr
 * @copyright       Copyright © 2017 Tassos Marinos All Rights Reserved
 * @license         GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
 */

namespace NRFramework\Assignments;

defined('_JEXEC') or die;

use NRFramework\Assignment;

class Component extends Assignment
{
    /**
     *  Returns the assignment's value
     * 
     *  @return string The component's name
     */
    public function value()
    {
        return $this->getComponent();
    }

    /**
     *  Return's the current component's name
     */
    protected function getComponent()
    {
        return $this->app->input->get("option");
    }
}