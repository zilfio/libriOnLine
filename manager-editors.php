<?php

session_start();

require "include/config.php";
require "include/auth.inc.php";

include 'services/EditorService.php';
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
    case '1': // ADD EDITOR
        if (!isset($_REQUEST['page'])) {
            $page = 0;
        } else {
            $page = $_REQUEST['page'];
        }

        switch ($page) {
            case 0: // FORM
                $smarty->assign('body', 'editors-add.tpl');
                break;

            case 1: // TRANSAZIONE + NOTIFICA
                $nome = $_REQUEST['nome'];
                
                //convalida input
                $errori = UtilsService::validate($nome, 1, "Nome obbligatorio", $errori);
                
                if(count($errori) == 0) {
                    
                    $editor = new Editore($id, $nome);
                    $success = intval(EditorService::insertEditor($editor));
                    if ($success > 0) { // fai il controllo se รจ maggiore di 0 direttamente
                        // l'editore ่ stato creato con successo nel database
                        $message = "L'editore e' stato creato con successo!";
                        $smarty->assign('body', 'alert.tpl');
                        $smarty->assign('success', 1);
                        $smarty->assign('message', $message);
                        header('Refresh: 2; URL=manager-editors.php');
                    } else {
                        // l'editore non ่ stato creato nel database
                        $message = "L'editore non e' stato creato!";
                        $smarty->assign('body', 'alert.tpl');
                        $smarty->assign('error', 1);
                        $smarty->assign('message', $message);
                        header('Refresh: 2; URL=manager-editors.php');
                    }
                } else {
                    $smarty->assign('body', 'editors-add.tpl');
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

    case '2': // UPDATE EDITOR
        if (!isset($_REQUEST['page'])) {
            $page = 0;
        } else {
            $page = $_REQUEST['page'];
        }

        switch ($page) {
            case 0: // FORM
                $id_editor = $_GET['id'];
                $editor = EditorService::getEditorById($id_editor);
                if ($editor) {
                	$smarty->assign('body', 'editors-update.tpl');
                	$smarty->assign('nome', $editor->getNome());
                } else {
                	$message = "Impossibile trovare l'editore!";
                	$smarty->assign('body', 'alert.tpl');
                	$smarty->assign('error', 1);
                	$smarty->assign('message', $message);
                	header('Refresh: 2; URL=manager-editors.php');
                }
                break;

            case 1: // TRANSAZIONE + NOTIFICA
                $nome = $_REQUEST['nome'];
                
                //convalida input
                $errori = UtilsService::validate($nome, 1, "Nome obbligatorio", $errori);
                
                if(count($errori) == 0) {
                    $id_editor = $_GET['id'];
                    $editor = new Editore($id_editor, $nome);
                    
                    $result = EditorService::updateEditor($editor);
                    if ($result) {
                        $message = "L'editore e' stato modificato con successo!";
                        $smarty->assign('body', 'alert.tpl');
                        $smarty->assign('success', 1);
                        $smarty->assign('message', $message);
                        header('Refresh: 2; URL=manager-editors.php');
                    } else {
                        $message = "L'editore non e' stato modificato!";
                        $smarty->assign('body', 'alert.tpl');
                        $smarty->assign('error', 1);
                        $smarty->assign('message', $message);
                        header('Refresh: 2; URL=manager-editors.php');
                    }
                } else {
                    $smarty->assign('body', 'editors-update.tpl');
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

    case '3': // DELETE EDITORS
        if (!isset($_REQUEST['page'])) {
            $page = 0;
        } else {
            $page = $_REQUEST['page'];
        }

        switch ($page) {
            case 0: // FORM
                $id_editor = $_GET['id'];
                $editor = EditorService::getEditorById($id_editor);
                if ($editor) {
                	$smarty->assign('body', 'editors-delete.tpl');
                	$smarty->assign('editor', $editor);
                } else {
                	$message = "Impossibile trovare l'editore!";
                	$smarty->assign('body', 'alert.tpl');
                	$smarty->assign('error', 1);
                	$smarty->assign('message', $message);
                	header('Refresh: 2; URL=manager-editors.php');
                }
                break;

            case 1: // TRANSAZIONE + NOTIFICA
                $id_editor = $_GET['id'];
                $editor = EditorService::getEditorById($id_editor);
                $result = EditorService::deleteEditor($editor);
                if ($result) {
                    $message = "L'editore e' stato eliminato con successo!";
                    $smarty->assign('body', 'alert.tpl');
                    $smarty->assign('success', 1);
                    $smarty->assign('message',$message);
                    header('Refresh: 2; URL=manager-editors.php');
                } else {
                    $message = "L'editore non e' stato eliminato!";
                    $smarty->assign('body', 'alert.tpl');
                    $smarty->assign('error', 1);
                    $smarty->assign('message',$message);
                    header('Refresh: 2; URL=manager-editors.php');
                }
                break;
        }
        break;

    default:
        $editors = EditorService::getAllEditors();
        $smarty->assign('editors', $editors);
        $smarty->assign('body', 'editors-report.tpl');
        break;
}

$smarty->display('backoffice.tpl');
?>