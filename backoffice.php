<?php

session_start();

include "include/config.php";
include "include/auth.inc.php";

include_once 'services/BookService.php';
include_once 'services/VolumeService.php';
include_once 'services/LoanService.php';
include_once 'services/UserService.php';

require_once(ROOT_SMARTY . 'Smarty.class.php');

$smarty = new Smarty;

$smarty->template_dir = 'skins/backend/dtml/';
$smarty->compile_dir = 'include/smarty/backend/templates_c/';
$smarty->config_dir = 'include/smarty/backend/configs/';
$smarty->cache_dir = 'include/smarty/backend/cache/';

$smarty->assign('body', 'welcome.tpl');
$smarty->assign('username',$_SESSION['user']['username']);

include_once 'include/admin.inc.php';

$smarty->assign('numberBooks',BookService::getNumberOfBooks());
$smarty->assign('numberLoans',LoanService::getNumberOfLoans());
$smarty->assign('numberActiveLoans',LoanService::getNumberOfActiveLoans());
$smarty->assign('numberUsers',UserService::getNumberOfUsers());

$smarty->display('backoffice.tpl');

?>