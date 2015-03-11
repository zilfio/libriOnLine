<?php

session_start();

require "include/config.php";
require "include/auth.inc.php";

include 'services/LanguageService.php';
include 'services/UtilsService.php';

require_once(ROOT_SMARTY . 'Smarty.class.php');

$smarty = new Smarty;

$smarty->template_dir = 'skins/backend/dtml/';
$smarty->compile_dir = 'include/smarty/backend/templates_c/';
$smarty->config_dir = 'include/smarty/backend/configs/';
$smarty->cache_dir = 'include/smarty/backend/cache/';

include_once 'include/admin.inc.php';

$action = $_GET['pid'];
$errori = array();

switch ($action) {
    case '1': // ADD TAG
        if (!isset($_REQUEST['page'])) {
            $page = 0;
        } else {
            $page = $_REQUEST['page'];
        }

        switch ($page) {
            case 0: // FORM
                $smarty->assign('body', 'languages-add.tpl');
                break;

            case 1: // TRANSAZIONE + NOTIFICA
                $nome = $_REQUEST['nome'];
                
                //convalida input
                $errori = UtilsService::validate($nome, 1, "Nome obbligatorio", $errori);
                
                if(count($errori) == 0) {
                    
                    $language = new Lingua($id, $nome);
                    $success = intval(LanguageService::insertLanguage($language));
                    if ($success > 0) { // fai il controllo se è maggiore di 0 direttamente
                        // la lingua è stato creato con successo nel database
                        $message = "La lingua e' stata creata con successo!";
                        $smarty->assign('body', 'alert.tpl');
                        $smarty->assign('success', 1);
                        $smarty->assign('message', $message);
                        header('Refresh: 2; URL=manager-languages.php');
                    } else {
                        // la lingua non è stato creato nel database
                        $message = "La lingua non e' stata creata!";
                        $smarty->assign('body', 'alert.tpl');
                        $smarty->assign('error', 1);
                        $smarty->assign('message', $message);
                        header('Refresh: 2; URL=manager-languages.php');
                    }
                } else {
                    $smarty->assign('body', 'languages-add.tpl');
                    $message = "Alcuni campi sono obbligatori!";
                    $smarty->assign('warning', 1);
                    $smarty->assign('message', $message);
                    $smarty->assign('errori', $errori);
                    
                    foreach ($_REQUEST as $index => $value) {
                        $smarty->assign($index, $value);
                    }
                }
                break;
        }
        break;

    case '2': // UPDATE TAG
        if (!isset($_REQUEST['page'])) {
            $page = 0;
        } else {
            $page = $_REQUEST['page'];
        }

        switch ($page) {
            case 0: // FORM
                $id_language = $_GET['id'];
                $language = LanguageService::getLanguageById($id_language);
                if ($language) {
                	$smarty->assign('body', 'languages-update.tpl');
                	$smarty->assign('nome', $language->getNome());
                } else {
                	$message = "Impossibile trovare la lingua!";
                	$smarty->assign('body', 'alert.tpl');
                	$smarty->assign('error', 1);
                	$smarty->assign('message', $message);
                	header('Refresh: 2; URL=manager-languages.php');
                }
                break;

            case 1: // TRANSAZIONE + NOTIFICA
                $nome = $_REQUEST['nome'];
                
                //convalida input
                $errori = UtilsService::validate($nome, 1, "Nome obbligatorio", $errori);
                
                if(count($errori) == 0) {
                    $id_language = $_GET['id'];
                    $language = new Lingua($id_language, $nome);
                    
                    $result = LanguageService::updateLanguage($language);
                    if ($result) {
                        $message = "La lingua e' stata modificata con successo!";
                        $smarty->assign('body', 'alert.tpl');
                        $smarty->assign('success', 1);
                        $smarty->assign('message', $message);
                        header('Refresh: 2; URL=manager-languages.php');
                    } else {
                        $message = "La lingua non e' stata modificata!";
                        $smarty->assign('body', 'alert.tpl');
                        $smarty->assign('error', 1);
                        $smarty->assign('message', $message);
                        header('Refresh: 2; URL=manager-languages.php');
                    }
                } else {
                    $smarty->assign('body', 'languages-update.tpl');
                    $message = "Alcuni campi sono obbligatori!";
                    $smarty->assign('warning', 1);
                    $smarty->assign('message', $message);
                    $smarty->assign('errori', $errori);
                    
                    foreach ($_REQUEST as $index => $value) {
                        $smarty->assign($index, $value);
                    }
                }
                break;
        }
        break;

    case '3': // DELETE TAG
        if (!isset($_REQUEST['page'])) {
            $page = 0;
        } else {
            $page = $_REQUEST['page'];
        }

        switch ($page) {
            case 0: // FORM
                $id_language = $_GET['id'];
                $language = LanguageService::getLanguageById($id_language);
                if ($language) {
                	$smarty->assign('body', 'languages-delete.tpl');
                	$smarty->assign('language', $language);
                } else {
                	$message = "Impossibile trovare la lingua!";
                	$smarty->assign('body', 'alert.tpl');
                	$smarty->assign('error', 1);
                	$smarty->assign('message', $message);
                	header('Refresh: 2; URL=manager-languages.php');
                }
                break;

            case 1: // TRANSAZIONE + NOTIFICA
                $id_language = $_GET['id'];
                $language = LanguageService::getLanguageById($id_language);
                $result = LanguageService::deleteLanguage($language);
                if ($result) {
                    $message = "La lingua e' stata eliminata con successo!";
                    $smarty->assign('body', 'alert.tpl');
                    $smarty->assign('success', 1);
                    $smarty->assign('message',$message);
                    header('Refresh: 2; URL=manager-languages.php');
                } else {
                    $message = "La lingua non e' stata eliminata!";
                    $smarty->assign('body', 'alert.tpl');
                    $smarty->assign('error', 1);
                    $smarty->assign('message',$message);
                    header('Refresh: 2; URL=manager-languages.php');
                }
                break;
        }
        break;

    default:
        $languages = LanguageService::getAllLanguages();
        $smarty->assign('languages', $languages);
        $smarty->assign('body', 'languages-report.tpl');
        break;
}

$smarty->display('backoffice.tpl');
?>