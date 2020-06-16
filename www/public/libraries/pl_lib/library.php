<?php
defined('_JEXEC') or die;

JLoader::setup();

JLoader::registerPrefix('PlLib', dirname(__FILE__));

$composerAutoload = __DIR__ . '/vendor/autoload.php';

if (file_exists($composerAutoload))
{
	$loader = require_once $composerAutoload;
}

$lang = JFactory::getLanguage();
$lang->load('pl_lib', JPATH_SITE);
