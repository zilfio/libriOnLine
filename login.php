<?php

session_start();

include 'services/LoginService.php';

include 'include/config.php';
require_once(ROOT_SMARTY . 'Smarty.class.php');

$smarty = new Smarty;

$smarty->template_dir = 'skins/frontend/dtml/';
$smarty->compile_dir = 'include/smarty/frontend/templates_c/';
$smarty->config_dir = 'include/smarty/frontend/configs/';
$smarty->cache_dir = 'include/smarty/frontend/cache/';

$loggato = LoginService::isLogged();
if (!$loggato) {
    $smarty->display('login.tpl');
} else {
    Header("Location: backoffice.php");
}

?>