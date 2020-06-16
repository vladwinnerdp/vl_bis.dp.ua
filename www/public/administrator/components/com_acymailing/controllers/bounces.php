<?php
/**
 * @package	AcyMailing for Joomla!
 * @version	5.10.4
 * @author	acyba.com
 * @copyright	(C) 2009-2018 ACYBA S.A.R.L. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');
?><?php

class BouncesController extends acymailingController{
	var $pkey = 'ruleid';
	var $table = 'rules';
	var $groupMap = '';
	var $groupVal = '';

	function listing(){
		if(!acymailing_level(3)){
			$acyToolbar = acymailing_get('helper.toolbar');
			$acyToolbar->setTitle(acymailing_translation('BOUNCE_HANDLING'), 'bounces');
			$acyToolbar->help('bounce');
			$acyToolbar->display();
			$config = acymailing_config();
			$level = $config->get('level');
			$url = ACYMAILING_HELPURL.'bounce-paidversion&utm_source=acymailing-'.$level.'&utm_medium=back-end&utm_content=bounces-display&utm_campaign=upgrade';
			$iFrame = "<iframe class='paidversion' frameborder='0' src='$url' width='100%' height='100%' scrolling='auto'></iframe>";
			echo $iFrame.'<div id="iframedoc"></div>';
			return;
		}

		return parent::listing();
	}

	function process(){
		if(!$this->isAllowed('configuration', 'manage')) return;
		acymailing_increasePerf();

		$config = acymailing_config();
		$bounceClass = acymailing_get('helper.bounce');
		$bounceClass->report = true;
		if(!$bounceClass->init()) return;
		if(!$bounceClass->connect()){
			acymailing_display($bounceClass->getErrors(), 'error');
			return;
		}
		$disp = "<html>\n<head>\n<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8\" />\n";
		$disp .= '<title>'.addslashes(acymailing_translation('BOUNCE_PROCESS')).'</title>'."\n";
		$disp .= "<style>body{font-size:12px;font-family: Arial,Helvetica,sans-serif;padding-top:30px;}</style>\n</head>\n<body>";
		echo $disp;

		acymailing_display(acymailing_translation_sprintf('BOUNCE_CONNECT_SUCC', $config->get('bounce_username')), 'success');
		$nbMessages = $bounceClass->getNBMessages();
		acymailing_display(acymailing_translation_sprintf('NB_MAIL_MAILBOX', $nbMessages), 'info');

		if(empty($nbMessages)) exit;

		$bounceClass->handleMessages();
		$bounceClass->close();

		$cronHelper = acymailing_get('helper.cron');
		$cronHelper->messages[] = acymailing_translation_sprintf('NB_MAIL_MAILBOX', $nbMessages);
		$cronHelper->detailMessages = $bounceClass->messages;
		$cronHelper->saveReport();

		if($config->get('bounce_max', 0) != 0 && $nbMessages > $config->get('bounce_max', 0)){
			$url = acymailing_completeLink('bounces&task=process&continuebounce=1', true, true);
			if(acymailing_getVar('int', 'continuebounce')){
				echo '<script type="text/javascript" language="javascript">document.location.href=\''.$url.'\';</script>';
			}else{
				echo '<div style="padding:20px;"><a href="'.$url.'">'.acymailing_translation('CLICK_HANDLE_ALL_BOUNCES').'</a></div>';
			}
		}

		echo "</body></html>";
		while($bounceClass->obend-- > 0){
			ob_start();
		}
		exit;
	}

	function store(){
		if(!$this->isAllowed('configuration', 'manage')) return;
		acymailing_checkToken();

		$class = acymailing_get('class.rules');
		$status = $class->saveForm();
		if($status){
			acymailing_enqueueMessage(acymailing_translation('JOOMEXT_SUCC_SAVED'), 'message');
		}else{
			acymailing_enqueueMessage(acymailing_translation('ERROR_SAVING'), 'error');
			if(!empty($class->errors)){
				foreach($class->errors as $oneError){
					acymailing_enqueueMessage($oneError, 'error');
				}
			}
		}
	}

	function remove(){
		if(!$this->isAllowed('configuration', 'manage')) return;
		acymailing_checkToken();

		$cids = acymailing_getVar('array', 'cid', array(), '');

		$class = acymailing_get('class.rules');
		$num = $class->delete($cids);

		if($num) acymailing_enqueueMessage(acymailing_translation_sprintf('SUCC_DELETE_ELEMENTS', $num), 'message');

		acymailing_setVar('layout', 'listing');
		return parent::display();
	}

	function saveconfig(){
		$this->_saveconfig();
		return $this->listing();
	}

	function _saveconfig(){
		if(!$this->isAllowed('configuration', 'manage')) return;
		acymailing_checkToken();

		$config = acymailing_config();
		$newConfig = acymailing_getVar('array', 'config', array(), 'POST');
		if(!empty($newConfig['bounce_username'])) $newConfig['bounce_username'] = acymailing_punycode($newConfig['bounce_username']);

		$newConfig['auto_bounce_next'] = min($config->get('auto_bounce_last', time()), time()) + $newConfig['auto_bounce_frequency'];

		$status = $config->save($newConfig);

		if($status){
			acymailing_enqueueMessage(acymailing_translation('JOOMEXT_SUCC_SAVED'), 'message');
		}else{
			acymailing_enqueueMessage(acymailing_translation('ERROR_SAVING'), 'error');
		}

		$config->load();
	}

	function chart(){
		acymailing_setVar('layout', 'chart');
		return parent::display();
	}

	function test(){

		$this->_saveconfig();

		acymailing_increasePerf();
		$config = acymailing_config();
		$bounceClass = acymailing_get('helper.bounce');
		$bounceClass->report = true;

		if($bounceClass->init()){
			if($bounceClass->connect()){
				$nbMessages = $bounceClass->getNBMessages();
				acymailing_enqueueMessage(acymailing_translation_sprintf('BOUNCE_CONNECT_SUCC', $config->get('bounce_username')));
				acymailing_enqueueMessage(acymailing_translation_sprintf('NB_MAIL_MAILBOX', $nbMessages));
				$bounceClass->close();
				if(!empty($nbMessages)){
					acymailing_enqueueMessage(acymailing_popup(acymailing_completeLink("bounces&task=process", true), acymailing_translation('CLICK_BOUNCE'), '', 640, 480, '', ' style="text-decoration:blink" '));
				}
			}else{
				$errors = $bounceClass->getErrors();
				if(!empty($errors)){
					acymailing_enqueueMessage($errors, 'error');
					$errorString = implode(' ', $errors);
					$port = $config->get('bounce_port', '');
					if(preg_match('#certificate#i', $errorString) && !$config->get('bounce_certif', false)){
						acymailing_enqueueMessage('You may need to turn ON the option <i>'.acymailing_translation('BOUNCE_CERTIF').'</i>', 'warning');
					}elseif(!empty($port) AND !in_array($port, array('993', '143', '110'))){
						acymailing_enqueueMessage('Are you sure you selected the right port? You can leave it empty if you do not know what to specify', 'warning');
					}
				}
			}
		}

		return $this->listing();
	}

	function reinstall(){

		acymailing_query('TRUNCATE TABLE `#__acymailing_rules`');

		$updateHelper = acymailing_get('helper.update');
		$updateHelper->installBounceRules();

		return $this->listing();
	}
}
