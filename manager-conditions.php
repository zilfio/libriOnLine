<?php

session_start();

require "include/config.php";
require "include/auth.inc.php";

include 'services/ConditionService.php';
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
    case '1': // ADD SERVICE
        if (!isset($_REQUEST['page'])) {
            $page = 0;
        } else {
            $page = $_REQUEST['page'];
        }

        switch ($page) {
            case 0: // FORM
                $smarty->assign('body', 'conditions-add.tpl');
                break;

            case 1: // TRANSAZIONE + NOTIFICA
                $nome = $_REQUEST['nome'];
                $descrizione = $_REQUEST['descrizione'];
                
                //convalida input
                $errori = UtilsService::validate($nome, 1, "Nome obbligatorio", $errori);
                
                if(count($errori) == 0) {
                    
                    $condition = new Condizione($id, $nome, $descrizione);
                    $success = intval(ConditionService::insertCondition($condition));
                    if ($success > 0) { // fai il controllo se è maggiore di 0 direttamente
                        // il servizio è stato creato con successo nel database
                        $message = "La condizione e' stata creata con successo!";
                        $smarty->assign('body', 'alert.tpl');
                        $smarty->assign('success', 1);
                        $smarty->assign('message', $message);
                        header('Refresh: 2; URL=manager-conditions.php');
                    } else {
                        // il servizio non è stato creato nel database
                        $message = "La condizione non e' stata creata!";
                        $smarty->assign('body', 'alert.tpl');
                        $smarty->assign('error', 1);
                        $smarty->assign('message', $message);
                        header('Refresh: 2; URL=manager-conditions.php');
                    }
                } else {
                    $smarty->assign('body', 'conditions-add.tpl');
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

    case '2': // UPDATE SERVICE
        if (!isset($_REQUEST['page'])) {
            $page = 0;
        } else {
            $page = $_REQUEST['page'];
        }

        switch ($page) {
            case 0: // FORM
                $id_condition = $_GET['id'];
                $condition = ConditionService::getConditionById($id_condition);
                if ($condition) {
                	$smarty->assign('body', 'conditions-update.tpl');
                	$smarty->assign('nome', $condition->getNome());
                	$smarty->assign('descrizione', $condition->getDescrizione());
                } else {
                	$message = "Impossibile trovare la condizione!";
                	$smarty->assign('body', 'alert.tpl');
                	$smarty->assign('error', 1);
                	$smarty->assign('message', $message);
                	header('Refresh: 2; URL=manager-conditions.php');
                }
                break;

            case 1: // TRANSAZIONE + NOTIFICA
                $nome = $_REQUEST['nome'];
                $descrizione = $_REQUEST['descrizione'];
                
                //convalida input
                $errori = UtilsService::validate($nome, 1, "Nome obbligatorio", $errori);
                
                if(count($errori) == 0) {
                    $id_condition = $_GET['id'];
                    $condition = new Condizione($id_condition, $nome, $descrizione);
                    
                    $result = ConditionService::updateCondition($condition);
                    if ($result) {
                        $message = "La condizione e' stata modificata con successo!";
                        $smarty->assign('body', 'alert.tpl');
                        $smarty->assign('success', 1);
                        $smarty->assign('message', $message);
                        header('Refresh: 2; URL=manager-conditions.php');
                    } else {
                        $message = "Il servizio non e' stata modificata!";
                        $smarty->assign('body', 'alert.tpl');
                        $smarty->assign('error', 1);
                        $smarty->assign('message', $message);
                        header('Refresh: 2; URL=manager-conditions.php');
                    }
                } else {
                    $smarty->assign('body', 'conditions-update.tpl');
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

    case '3': // DELETE SERVICE
        if (!isset($_REQUEST['page'])) {
            $page = 0;
        } else {
            $page = $_REQUEST['page'];
        }

        switch ($page) {
            case 0: // FORM
                $id_condition = $_GET['id'];
                $condition = ConditionService::getConditionById($id_condition);
                if ($condition) {
                	$smarty->assign('body', 'conditions-delete.tpl');
                	$smarty->assign('condition', $condition);
                } else {
                	$message = "Impossibile trovare la condizione!";
                	$smarty->assign('body', 'alert.tpl');
                	$smarty->assign('error', 1);
                	$smarty->assign('message', $message);
                	header('Refresh: 2; URL=manager-conditions.php');
                }
                break;

            case 1: // TRANSAZIONE + NOTIFICA
                $id_condition = $_GET['id'];
                $condition = ConditionService::getConditionById($id_condition);
                $result = ConditionService::deleteCondition($condition);
                if ($result) {
                    $message = "La condizione e' stata eliminata con successo!";
                    $smarty->assign('body', 'alert.tpl');
                    $smarty->assign('success', 1);
                    $smarty->assign('message',$message);
                    header('Refresh: 2; URL=manager-conditions.php');
                } else {
                    $message = "La condizione non e' stata eliminata!";
                    $smarty->assign('body', 'alert.tpl');
                    $smarty->assign('error', 1);
                    $smarty->assign('message',$message);
                    header('Refresh: 2; URL=manager-conditions.php');
                }
                break;
        }
        break;

    default:
        $conditions = ConditionService::getAllConditions();
        $smarty->assign('conditions', $conditions);
        $smarty->assign('body', 'conditions-report.tpl');
        break;
}

$smarty->display('backoffice.tpl');
?>