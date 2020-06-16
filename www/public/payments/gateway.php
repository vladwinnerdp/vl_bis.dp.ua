<?php
define('_JEXEC', 1);
define('JPATH_BASE', '/var/www/bis/');


require_once JPATH_BASE . 'includes/defines.php';
require_once JPATH_BASE . 'includes/framework.php';

$app = JFactory::getApplication('site');

$db = JFactory::getDBO();

if (!empty($_POST['ik_pm_no']) && !empty($_POST['ik_inv_st']) && $_POST['ik_inv_st'] == 'success') {
		if(!include_once(rtrim(JPATH_ADMINISTRATOR,DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_acymailing'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'helper.php')){
			echo 'This code can not work without the AcyMailing Component';
			return false;
		}
		
	
		$query = 'SELECT * FROM #__bis_order WHERE id = '.intval($_POST['ik_pm_no']);
        $db->setQuery($query);
        $order = $db->loadObject();		
		
		// Get the subscriber ID (ID of the AcyMailing user) from his email address or his Joomla user ID
		$userClass = acymailing_get('class.subscriber');
		$subid = $userClass->subid($order->email);
 
		// Get subscription
		$listsubClass = acymailing_get('class.listsub');
		$newSubscription = array();
		$userSubscriptions = $listsubClass->getSubscription($subid);
		foreach($userSubscriptions as $listId=>$subscription) {
			$newList = array();
			$newList['status'] = $subscription->status;
			$newSubscription[$listId] = $newList;			
		}
		
		$newList = array();
		$status = !empty($userSubscriptions[2])?$userSubscriptions[2]->status:2;
		$newList['status'] = $status;
		$newSubscription[3] = $newList;
		$userClass->saveSubscription($subid,$newSubscription);		
		
}