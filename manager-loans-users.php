<?php

session_start();

require "include/config.php";
require "include/auth.inc.php";

include 'services/LoanService.php';
include 'services/VolumeService.php';
include 'services/ConditionService.php';
include 'services/BookService.php';
include 'services/AuthorService.php';
include 'services/TagService.php';
include 'services/UserService.php';
include 'services/GroupService.php';
include 'services/UtilsService.php';

require_once(ROOT_SMARTY . 'Smarty.class.php');

$smarty = new Smarty;

$smarty->template_dir = 'skins/backend/dtml/';
$smarty->compile_dir = 'include/smarty/backend/templates_c/';
$smarty->config_dir = 'include/smarty/backend/configs/';
$smarty->cache_dir = 'include/smarty/backend/cache/';

include_once 'include/admin.inc.php';

$pid = $_GET['pid'];
$errori = array();

switch ($pid) {

    case '1':
        $user = UserService::getUserById($_SESSION['user']['id']);
        $activeLoans = LoanService::getAllActiveLoanByUser($user);
        $smarty->assign('body', 'loans-active-user.tpl');
        $smarty->assign('loans', $activeLoans);
        $smarty->assign('date', date('Y-m-d'));
        break;

    default :
        $user = UserService::getUserById($_SESSION['user']['id']);
        $allLoans = LoanService::getAllLoansByUser($user);
        $smarty->assign('body', 'loans-report-user.tpl');
        $smarty->assign('loans', $allLoans);
        $smarty->assign('date', date('Y-m-d'));
        break;
}

$smarty->display('backoffice.tpl');
?>