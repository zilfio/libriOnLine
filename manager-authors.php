<?php

session_start();

require "include/config.php";
require "include/auth.inc.php";

include 'services/AuthorService.php';
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
    case '1': // ADD AUTHOR
        if (!isset($_REQUEST['page'])) {
            $page = 0;
        } else {
            $page = $_REQUEST['page'];
        }

        switch ($page) {
            case 0: // FORM
                $smarty->assign('body', 'authors-add.tpl');
                break;

            case 1: // TRANSAZIONE + NOTIFICA
                $nome = $_REQUEST['nome'];
                $cognome = $_REQUEST['cognome'];
                
                //convalida input
                $errori = UtilsService::validate($nome, 1, "Nome obbligatorio", $errori);
                $errori = UtilsService::validate($cognome, 1, "Cognome obbligatorio", $errori);
                
                if(count($errori) == 0) {
                    
                    $author = new Autore($id, $nome, $cognome);
                    $success = intval(AuthorService::insertAuthor($author));
                    if ($success > 0) { // fai il controllo se รจ maggiore di 0 direttamente
                        // l'autore ่ stato creato con successo nel database
                        $message = "L'autore e' stato creato con successo!";
                        $smarty->assign('body', 'alert.tpl');
                        $smarty->assign('success', 1);
                        $smarty->assign('message', $message);
                        header('Refresh: 2; URL=manager-authors.php');
                    } else {
                        // l'autore non ่ stato creato nel database
                        $message = "L'autore non e' stato creato!";
                        $smarty->assign('body', 'alert.tpl');
                        $smarty->assign('error', 1);
                        $smarty->assign('message', $message);
                        header('Refresh: 2; URL=manager-authors.php');
                    }
                } else {
                    $smarty->assign('body', 'authors-add.tpl');
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

    case '2': // UPDATE AUTHOR
        if (!isset($_REQUEST['page'])) {
            $page = 0;
        } else {
            $page = $_REQUEST['page'];
        }

        switch ($page) {
            case 0: // FORM
                $id_author = $_GET['id'];
                $author = AuthorService::getAuthorById($id_author);
                if ($author) {
                	$smarty->assign('body', 'authors-update.tpl');
                	$smarty->assign('nome', $author->getNome());
                	$smarty->assign('cognome', $author->getCognome());
                } else {
                	$message = "Impossibile trovare l'autore!";
                	$smarty->assign('body', 'alert.tpl');
                	$smarty->assign('error', 1);
                	$smarty->assign('message', $message);
                	header('Refresh: 2; URL=manager-authors.php');
                }
                break;

            case 1: // TRANSAZIONE + NOTIFICA
                $nome = $_REQUEST['nome'];
                $cognome = $_REQUEST['cognome'];
                
                //convalida input
                $errori = UtilsService::validate($nome, 1, "Nome obbligatorio", $errori);
                $errori = UtilsService::validate($cognome, 1, "Cognome obbligatorio", $errori);
                
                if(count($errori) == 0) {
                    $id_author = $_GET['id'];
                    $author = new Autore($id_author, $nome, $cognome);
                    
                    $result = AuthorService::updateAuthor($author);
                    if ($result) {
                        $message = "L'autore e' stato modificato con successo!";
                        $smarty->assign('body', 'alert.tpl');
                        $smarty->assign('success', 1);
                        $smarty->assign('message', $message);
                        header('Refresh: 2; URL=manager-authors.php');
                    } else {
                        $message = "L'autore non e' stato modificato!";
                        $smarty->assign('body', 'alert.tpl');
                        $smarty->assign('error', 1);
                        $smarty->assign('message', $message);
                        header('Refresh: 2; URL=manager-authors.php');
                    }
                } else {
                    $smarty->assign('body', 'authors-update.tpl');
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

    case '3': // DELETE AUTHOR
        if (!isset($_REQUEST['page'])) {
            $page = 0;
        } else {
            $page = $_REQUEST['page'];
        }

        switch ($page) {
            case 0: // FORM
                $id_author = $_GET['id'];
                $author = AuthorService::getAuthorById($id_author);
                if ($author) {
                	$smarty->assign('body', 'authors-delete.tpl');
                	$smarty->assign('author', $author);
                } else {
                	$message = "Impossibile trovare l'autore!";
                	$smarty->assign('body', 'alert.tpl');
                	$smarty->assign('error', 1);
                	$smarty->assign('message', $message);
                	header('Refresh: 2; URL=manager-authors.php');
                }
                break;

            case 1: // TRANSAZIONE + NOTIFICA
                $id_author = $_GET['id'];
                $author = AuthorService::getAuthorById($id_author);
                $result = AuthorService::deleteAuthor($author);
                if ($result) {
                    $message = "L'autore e' stato eliminato con successo!";
                    $smarty->assign('body', 'alert.tpl');
                    $smarty->assign('success', 1);
                    $smarty->assign('message',$message);
                    header('Refresh: 2; URL=manager-authors.php');
                } else {
                    $message = "L'autore non e' stato eliminato!";
                    $smarty->assign('body', 'alert.tpl');
                    $smarty->assign('error', 1);
                    $smarty->assign('message',$message);
                    header('Refresh: 2; URL=manager-authors.php');
                }
                break;
        }
        break;

    default:
        $authors = AuthorService::getAllAuthors();
        $smarty->assign('authors', $authors);
        $smarty->assign('body', 'authors-report.tpl');
        break;
}

$smarty->display('backoffice.tpl');
?>