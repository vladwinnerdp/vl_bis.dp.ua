<?php defined('_JEXEC') or die;

// Import library dependencies
jimport('joomla.plugin.plugin');

class plgAjaxRequests extends JPlugin
{
    function onAjaxRequests()
    {
		$app = JFactory::getApplication();
		$formData = $app->input->post->getArray();
		if (!empty($formData['cf'])) {
			$counter = file_get_contents('/var/www/bis/counters/requests.txt');
			$counter++;
			$logLine = $counter;
			foreach($formData['cf'] as $key=>$value) {
				$logLine .= ' '.$key.': '.$value;
			}
			$logLine .= ' Amount='.$formData['ik_am'];
			file_put_contents('/var/www/bis/webinarusers.txt', $logLine."\r\n", FILE_APPEND);
			file_put_contents('/var/www/bis/counters/requests.txt', $counter);
			
			$db = JFactory::getDbo();
			
			$db->setQuery('INSERT INTO #__bis_order (`id`,`name`,`email`,`phone`,`amount`,`webinar`) VALUES ('.$counter.','.$db->Quote($formData["cf"]["name"]).','.$db->Quote($formData["cf"]["email"]).','.$db->Quote($formData["cf"]["phone"]).','.$db->Quote($formData["ik_am"]).','.$db->Quote($formData["ik_desc"]).')');
			
			$db->execute();
			
			return $counter;
		}
		return 0;
    }

}