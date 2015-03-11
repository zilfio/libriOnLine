<?php

require_once(ROOT_SMARTY . 'Smarty.class.php');

$smarty = new Smarty;

$smarty->template_dir = 'skins/backend/dtml/';
$smarty->compile_dir = 'include/smarty/backend/templates_c/';
$smarty->config_dir = 'include/smarty/backend/configs/';
$smarty->cache_dir = 'include/smarty/backend/cache/';

include 'services/LoginService.php';

$loggato = LoginService::isLogged();
if (!$loggato) {
    Header("Location: index.php");
    exit;
}

$authorized = LoginService::havePermission();
if (!$authorized) {
	Header("Location: backoffice.php");
}

?>