<?php

session_start();

require "include/config.php";
require "include/auth.inc.php";

include 'services/TagService.php';
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
                $smarty->assign('body', 'tags-add.tpl');
                break;

            case 1: // TRANSAZIONE + NOTIFICA
                $nome = $_REQUEST['nome'];
                
                //convalida input
                $errori = UtilsService::validate($nome, 1, "Nome obbligatorio", $errori);
                
                if(count($errori) == 0) {
                    
                    $tag = new Tag($id, $nome);
                    $success = intval(TagService::insertTag($tag));
                    if ($success > 0) { // fai il controllo se รจ maggiore di 0 direttamente
                        // il tag ่ stato creato con successo nel database
                        $message = "Il tag e' stato creato con successo!";
                        $smarty->assign('body', 'alert.tpl');
                        $smarty->assign('success', 1);
                        $smarty->assign('message', $message);
                        header('Refresh: 2; URL=manager-tags.php');
                    } else {
                        // il tag non ่ stato creato nel database
                        $message = "Il tag non e' stato creato!";
                        $smarty->assign('body', 'alert.tpl');
                        $smarty->assign('error', 1);
                        $smarty->assign('message', $message);
                        header('Refresh: 2; URL=manager-tags.php');
                    }
                } else {
                    $smarty->assign('body', 'tags-add.tpl');
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
                $id_tag = $_GET['id'];
                $tag = TagService::getTagById($id_tag);
                if ($tag) {
                	$smarty->assign('body', 'tags-update.tpl');
                	$smarty->assign('nome', $tag->getNome());
                } else {
                	$message = "Impossibile trovare il tag!";
                	$smarty->assign('body', 'alert.tpl');
                	$smarty->assign('error', 1);
                	$smarty->assign('message', $message);
                	header('Refresh: 2; URL=manager-tags.php');
                }
                break;

            case 1: // TRANSAZIONE + NOTIFICA
                $nome = $_REQUEST['nome'];
                
                //convalida input
                $errori = UtilsService::validate($nome, 1, "Nome obbligatorio", $errori);
                
                if(count($errori) == 0) {
                    $id_tag = $_GET['id'];
                    $tag = new Tag($id_tag, $nome);
                    
                    $result = TagService::updateTag($tag);
                    if ($result) {
                        $message = "Il tag e' stato modificato con successo!";
                        $smarty->assign('body', 'alert.tpl');
                        $smarty->assign('success', 1);
                        $smarty->assign('message', $message);
                        header('Refresh: 2; URL=manager-tags.php');
                    } else {
                        $message = "Il tag non e' stato modificato!";
                        $smarty->assign('body', 'alert.tpl');
                        $smarty->assign('error', 1);
                        $smarty->assign('message', $message);
                        header('Refresh: 2; URL=manager-tags.php');
                    }
                } else {
                    $smarty->assign('body', 'tags-update.tpl');
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
                $id_tag = $_GET['id'];
                $tag = TagService::getTagById($id_tag);
                if ($tag) {
                	$smarty->assign('body', 'tags-delete.tpl');
                	$smarty->assign('tag', $tag);
                } else {
                	$message = "Impossibile trovare il tag!";
                	$smarty->assign('body', 'alert.tpl');
                	$smarty->assign('error', 1);
                	$smarty->assign('message', $message);
                	header('Refresh: 2; URL=manager-tags.php');
                }
                break;

            case 1: // TRANSAZIONE + NOTIFICA
                $id_tag = $_GET['id'];
                $tag = TagService::getTagById($id_tag);
                $result = TagService::deleteTag($tag);
                if ($result) {
                    $message = "Il tag e' stato eliminato con successo!";
                    $smarty->assign('body', 'alert.tpl');
                    $smarty->assign('success', 1);
                    $smarty->assign('message',$message);
                    header('Refresh: 2; URL=manager-tags.php');
                } else {
                    $message = "Il tag non e' stato eliminato!";
                    $smarty->assign('body', 'alert.tpl');
                    $smarty->assign('error', 1);
                    $smarty->assign('message',$message);
                    header('Refresh: 2; URL=manager-tags.php');
                }
                break;
        }
        break;

    default:
        $tags = TagService::getAllTags();
        $smarty->assign('tags', $tags);
        $smarty->assign('body', 'tags-report.tpl');
        break;
}

$smarty->display('backoffice.tpl');
?>