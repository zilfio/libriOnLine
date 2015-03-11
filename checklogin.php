<?php

session_start();

include 'services/UtilsService.php';
include 'services/UserService.php';
include 'services/ServiceService.php';

include 'include/config.php';
require_once(ROOT_SMARTY . 'Smarty.class.php');

$smarty = new Smarty;

$smarty->template_dir = 'skins/frontend/dtml/';
$smarty->compile_dir = 'include/smarty/frontend/templates_c/';
$smarty->config_dir = 'include/smarty/frontend/configs/';
$smarty->cache_dir = 'include/smarty/frontend/cache/';

$errori = array();

$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

//convalida input
$errori = UtilsService::validate($username, 1, "Username obbligatorio", $errori);
$errori = UtilsService::validate($password, 1, "Password obbligatoria", $errori);

if (count($errori) == 0) {
    $oid = UserService::getUserByUsernameAndPassword($username, $password);

    if (!$oid) {
        $message = "Username o/e password errati!";
        $smarty->assign('warning', 1);
        $smarty->assign('message', $message);
        $smarty->display('login.tpl');
    } else {
        $_SESSION['user'] = $oid;

        $services = ServiceService::getServicesByUsername($username);

        foreach ($services as $service) {
            $result[$service] = TRUE;
        }

        $_SESSION['services'] = $result;

        header("location: backoffice.php");
    }
} else {
    $message = "Alcuni campi sono obbligatori!";
    $smarty->assign('warning', 1);
    $smarty->assign('message', $message);
    $smarty->assign('errori', $errori);
    $smarty->display('login.tpl');
}
?>