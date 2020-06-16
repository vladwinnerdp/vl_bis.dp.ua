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

namespace ConvertForms\Field;

defined('_JEXEC') or die('Restricted access');

class Country extends \ConvertForms\FieldChoice
{
	protected $inheritInputLayout = 'dropdown';

	/**
	 *  Set the field choices
	 *
	 *  @return  array  The field choices array
	 */
    protected function getChoices()
    {	
    	// Get list of all countries
    	$countries = \NRFramework\Countries::$map;
		asort($countries);

		$choices = array();

		// Detect visitor's country
		if ($this->field->detectcountry && $visitorCountryCode = $this->getVisitorCountryCode())
		{
			$this->field->value = $visitorCountryCode;
		}

		foreach ($countries as $countryCode => $countryName)
		{
			$choices[] = array(
				'value'    => $this->field->save == 'name' ? $countryName : $countryCode,
				'label'    => $countryName,
				'selected' => in_array(strtolower($this->field->value), array(strtolower($countryCode), strtolower($countryName)))
			);
		}

		return $choices;
    }

    /**
     *  Detect visitor's country
     *
     *  @return  string   The visitor's country code (GR)
     */
    private function getVisitorCountryCode()
    {
    	$path = JPATH_PLUGINS . '/system/tgeoip/';

    	if (!\JFolder::exists($path))
    	{
    		return;
    	}

    	if (!class_exists('TGeoIP'))
    	{
        	@include_once $path . 'vendor/autoload.php';
        	@include_once $path . 'helper/tgeoip.php';
    	}

        $geo = new \TGeoIP();
        return $geo->getCountryCode();
    }
}

?>