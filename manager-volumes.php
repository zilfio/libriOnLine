<?php

session_start();

require "include/config.php";
require "include/auth.inc.php";

include 'services/VolumeService.php';
include 'services/ConditionService.php';
include 'services/BookService.php';
include 'services/AuthorService.php';
include 'services/TagService.php';
include 'services/UtilsService.php';

require_once(ROOT_SMARTY . 'Smarty.class.php');

$smarty = new Smarty;

$smarty->template_dir = 'skins/backend/dtml/';
$smarty->compile_dir = 'include/smarty/backend/templates_c/';
$smarty->config_dir = 'include/smarty/backend/configs/';
$smarty->cache_dir = 'include/smarty/backend/cache/';

include_once 'include/admin.inc.php';

$isbn = $_GET['isbn'];
$action = $_GET['pid'];
$errori = array();

switch ($action) {
    case '1': // ADD VOLUME
        if (!isset($_REQUEST['page'])) {
            $page = 0;
        } else {
            $page = $_REQUEST['page'];
        }

        switch ($page) {
            case 0: // FORM
                $smarty->assign('body', 'volumes-add.tpl');
                $conditions = ConditionService::getAllConditions();
                $smarty->assign('condizioni', $conditions);
                if (isset($isbn)) {
                    $smarty->assign('book', 0);
                } else {
                    $smarty->assign('book', 1);
                    $books = BookService::getAllBooks();
                    $smarty->assign('books', $books);
                }
                break;

            case 1: // TRANSAZIONE + NOTIFICA
                $numeroVolumi = $_REQUEST['numeroVolumi'];
                $condizione = $_REQUEST['condizione'];
                $libro = $_REQUEST['libro'];

                //convalida input
                $errori = UtilsService::validate($numeroVolumi, 1, "Numero volumi obbligatorio", $errori);

                if (count($errori) == 0) {

                    $condition = ConditionService::getConditionById($condizione);

                    if (isset($isbn)) {
                        $volume = new Volume($id, $condition, BookService::getBookByIsbn($isbn));
                    } else {
                        $volume = new Volume($id, $condition, BookService::getBookByIsbn($libro));
                    }
                    $success = intval(VolumeService::insertVolume($volume, $numeroVolumi));
                    if ($success > 0) { // fai il controllo se è maggiore di 0 direttamente
                        // il/i volume/i è stato creato con successo nel database
                        if ($numeroVolumi > 1) {
                            $message = "I volumi sono stati aggiunti con successo!";
                        } else {
                            $message = "Il volume e' stato aggiunto con successo!";
                        }
                        $smarty->assign('body', 'alert.tpl');
                        $smarty->assign('success', 1);
                        $smarty->assign('message', $message);
                        if (isset($isbn)) {
                            $url = 'manager-volumes.php?isbn=' . $isbn;
                            header('Refresh: 2; URL=' . $url);
                        } else {
                            header('Refresh: 2; URL=manager-volumes.php');
                        }
                    } else {
                        // il servizio non è stato creato nel database
                        if ($numeroVolumi > 1) {
                            $message = "I volumi non sono stati creati!";
                        } else {
                            $message = "Il volume non è stato creato!";
                        }
                        $smarty->assign('body', 'alert.tpl');
                        $smarty->assign('error', 1);
                        $smarty->assign('message', $message);
                        if (isset($isbn)) {
                            $url = 'manager-volumes.php?isbn=' . $isbn;
                            header('Refresh: 2; URL=' . $url);
                        } else {
                            header('Refresh: 2; URL=manager-volumes.php');
                        }
                    }
                } else {
                    $smarty->assign('body', 'volumes-add.tpl');
                    $message = "Alcuni campi sono obbligatori!";
                    $smarty->assign('warning', 1);
                    $smarty->assign('message', $message);
                    $smarty->assign('errori', $errori);

                    foreach ($_REQUEST as $index => $value) {
                        $smarty->assign($index, $value);
                    }

                    // riscrivo la condizione nelle option
                    $selectedCondition = ConditionService::getConditionById($condizione);
                    $array = new ArrayObject;
                    $array->append($selectedCondition);
                    $smarty->assign('selectedCondition', $selectedCondition);
                    $smarty->assign('condizioni', UtilsService::filterArraysObject(ConditionService::getAllConditions(), $array));

                    if (!isset($isbn)) {
                        $smarty->assign('book', 1);
                        $selectedBook = BookService::getBookByIsbn($libro);
                        $array = new ArrayObject;
                        $array->append($selectedBook);
                        $smarty->assign('selectedBook', $selectedBook);
                        $smarty->assign('books', UtilsService::filterArraysObject2(BookService::getAllBooks(), $array));
                    }
                }
                break;
        }
        break;

    case '2': // UPDATE VOLUME
        if (!isset($_REQUEST['page'])) {
            $page = 0;
        } else {
            $page = $_REQUEST['page'];
        }

        switch ($page) {
            case 0: // FORM
                $id_volume = $_GET['id'];
                $volume = VolumeService::getVolumeById($id_volume);
                
                if ($volume) {
                	$smarty->assign('body', 'volumes-update.tpl');
                	
                	$condizione = $volume->getCondizione();
                	$array = new ArrayObject;
                	$array->append($condizione);
                	$smarty->assign('selectedCondition', $condizione);
                	$smarty->assign('conditions', UtilsService::filterArraysObject(ConditionService::getAllConditions(), $array));
                	
                	$book = $volume->getLibro();
                	$smarty->assign('book', $book);
                } else {
                	$message = "Impossibile trovare il volume!";
                	$smarty->assign('body', 'alert.tpl');
                	$smarty->assign('error', 1);
                	$smarty->assign('message', $message);
                	header('Refresh: 2; URL=manager-volumes.php');
                }
                break;

            case 1: // TRANSAZIONE + NOTIFICA
            	$id_volume = $_GET['id'];
                $condition = $_REQUEST['condizione'];

                $volume = VolumeService::getVolumeById($id_volume);
                $condizione = ConditionService::getConditionById($condition);
                
                $volume = new Volume($id_volume, $condizione, $volume->getLibro());

                $result = VolumeService::updateVolume($volume);
                if ($result) {
                    $message = "Il volume e' stato modificato con successo!";
                    $smarty->assign('body', 'alert.tpl');
                    $smarty->assign('success', 1);
                    $smarty->assign('message', $message);
                    if (isset($isbn)) {
                        $url = 'manager-volumes.php?isbn=' . $isbn;
                        header('Refresh: 2; URL=' . $url);
                    } else {
                        header('Refresh: 2; URL=manager-volumes.php');
                    }
                } else {
                    $message = "Il volume non e' stato modificato!";
                    $smarty->assign('body', 'alert.tpl');
                    $smarty->assign('error', 1);
                    $smarty->assign('message', $message);
                    if (isset($isbn)) {
                        $url = 'manager-volumes.php?isbn=' . $isbn;
                        header('Refresh: 2; URL=' . $url);
                    } else {
                        header('Refresh: 2; URL=manager-volumes.php');
                    }
                }
                break;
        }
        break;

    case '3': // DELETE VOLUME
        if (!isset($_REQUEST['page'])) {
            $page = 0;
        } else {
            $page = $_REQUEST['page'];
        }

        switch ($page) {
            case 0: // FORM
                $id_volume = $_GET['id'];
                $volume = VolumeService::getVolumeById($id_volume);
                if ($volume) {
                	$smarty->assign('body', 'volumes-delete.tpl');
                	$smarty->assign('volume', $volume);
                } else {
                	$message = "Impossibile trovare il volume!";
                	$smarty->assign('body', 'alert.tpl');
                	$smarty->assign('error', 1);
                	$smarty->assign('message', $message);
                	header('Refresh: 2; URL=manager-volumes.php');
                }
                break;

            case 1: // TRANSAZIONE + NOTIFICA
                $id_volume = $_GET['id'];
                $volume = VolumeService::getVolumeById($id_volume);
                $result = VolumeService::deleteVolume($volume);
                if ($result) {
                    $message = "Il volume e' stato eliminato con successo!";
                    $smarty->assign('body', 'alert.tpl');
                    $smarty->assign('success', 1);
                    $smarty->assign('message', $message);
                    if (isset($isbn)) {
                        $url = 'manager-volumes.php?isbn=' . $isbn;
                        header('Refresh: 2; URL=' . $url);
                    } else {
                        header('Refresh: 2; URL=manager-volumes.php');
                    }
                } else {
                    $message = "Il volume non e' stato eliminato!";
                    $smarty->assign('body', 'alert.tpl');
                    $smarty->assign('error', 1);
                    $smarty->assign('message', $message);
                    if (isset($isbn)) {
                        $url = 'manager-volumes.php?isbn=' . $isbn;
                        header('Refresh: 2; URL=' . $url);
                    } else {
                        header('Refresh: 2; URL=manager-volumes.php');
                    }
                }
                break;
        }
        break;

    default:
        if (isset($isbn)) {
            $book = BookService::getBookByIsbn($isbn);
            if ($book) {
            	$volumes = VolumeService::getAllVolumesByIsbn($isbn);
            	$smarty->assign('isbn', $isbn);
            	$smarty->assign('volumes', $volumes);
            	$smarty->assign('body', 'volumes-report.tpl');
            } else {
            	$message = "Impossibile trovare il libro!";
            	$smarty->assign('body', 'alert.tpl');
            	$smarty->assign('error', 1);
            	$smarty->assign('message', $message);
            	header('Refresh: 2; URL=manager-volumes.php');
            }

        } else {
            $volumes = VolumeService::getAllVolumes();
            $smarty->assign('volumes', $volumes);
            $smarty->assign('body', 'volumes-report.tpl');
        }

        break;
}

$smarty->display('backoffice.tpl');
?>