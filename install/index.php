<?php
/************************************************************************
 * This file is part of EspoCRM.
 *
 * EspoCRM - Open Source CRM application.
 * Copyright (C) 2014  Yuri Kuznetsov, Taras Machyshyn, Oleksiy Avramenko
 * Website: http://www.espocrm.com
 *
 * EspoCRM is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * EspoCRM is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with EspoCRM. If not, see http://www.gnu.org/licenses/.
 ************************************************************************/ 

error_reporting(0);
session_start();

require_once('../bootstrap.php');

require_once ('install/vendor/smarty/libs/Smarty.class.php');

require_once 'core/Installer.php';

require_once 'core/SystemTest.php';

$smarty = new Smarty();
$installer = new Installer();

// check if app was installed
if ($installer->isInstalled() && !isset($_SESSION['install']['installProcess'])) {
	$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$url = preg_replace('/install\/?/', '', $url, 1);
	$url = strtok($url, '#');
	$url = strtok($url, '?');
	header("Location: {$url}");
	exit;
}
else {
	// double check if infinite loop
	$_SESSION['install']['installProcess'] = true;
}

$smarty->caching = false;
$smarty->setTemplateDir('install/core/tpl');

// temp save all settings
$ignore = array('desc', 'dbName', 'hostName', 'dbUserName', 'dbUserPass', 'dbDriver');
if (!empty($_REQUEST)) {
	foreach ($_REQUEST as $key => $val) {
		if (!in_array($val, $ignore))
		$_SESSION['install'][$key] = $val;
	}
}

// get user selected language
$userLang = (!empty($_SESSION['install']['user-lang']))? $_SESSION['install']['user-lang'] : 'en_US';
$langFileName = 'core/i18n/'.$userLang.'.php';
$langs = array();
if (file_exists('install/'.$langFileName)) {
	$langs = include($langFileName);
} else {
	$langs = include('core/i18n/en_US.php');
}

$smarty->assign("langs", $langs);
$smarty->assign("langsJs", json_encode($langs));

$systemTest = new SystemTest();

// include actions and set tpl name
$tplName = 'main.tpl';
$actionsDir = 'core/actions';
$actionFile = '';
$action = (!empty($_REQUEST['action']))? $_REQUEST['action'] : 'main';

switch ($action) {
	case 'main':
		$languageList = $installer->getLanguageList();
		$smarty->assign("languageList", $languageList); 
		break;

	case 'step3':
	case 'errors':
    	$ajaxUrls = $installer->getAjaxUrls();
		$smarty->assign("ajaxUrls", json_encode($ajaxUrls));  
		break;

    case 'step4':
    case 'errors':
    	$settingsDefaults = $installer->getSettingDefaults();
		$smarty->assign("settingsDefaults", $settingsDefaults);    
		break; 		
}

$actionFile = $actionsDir.'/'.$action.'.php';
$tplName = $action.'.tpl';
$smarty->assign('tplName', $tplName);

if (!empty($actionFile) && file_exists('install/'.$actionFile)) {
	include $actionFile;
}


if (!empty($actionFile) && file_exists('install/core/tpl/'.$tplName)) {
	ob_clean();
	$smarty->display('index.tpl');
}