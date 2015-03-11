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
    case '1': // LOANS ACTIVE
        $activeLoans = LoanService::getAllActiveLoan();
        $smarty->assign('body', 'loans-active.tpl');
        $smarty->assign('loans', $activeLoans);
        $smarty->assign('date', date('Y-m-d'));
        break;

    case '2': // CLOSE LOAN
        if (!isset($_REQUEST['page'])) {
            $page = 0;
        } else {
            $page = $_REQUEST['page'];
        }

        switch ($page) {
            case 0: // DETAIL LOAN
                $id = $_GET['id'];
                $loan = LoanService::getLoanById($id);
                if ($loan) {
                	$smarty->assign('body', 'loans-close.tpl');
                	$smarty->assign('loan', $loan);
                } else {
                	$message = "Impossibile trovare il prestito!";
                	$smarty->assign('body', 'alert.tpl');
                	$smarty->assign('error', 1);
                	$smarty->assign('message', $message);
                	header('Refresh: 2; URL=manager-loans.php?pid=1');
                }
                break;

            case 1: // TRANSAZIONE + NOTIFICA (chiusura del prestito)
                $id = $_GET['id'];
                $loan = LoanService::getLoanById($id);
                $date = date('Y-m-d');
                $success = intval(LoanService::closeLoan($loan, $date));
                if ($success > 0) { // fai il controllo se ่ maggiore di 0 direttamente
                    // il servizio ่ stato creato con successo nel database
                    $message = "Il prestito e' stato chiuso con successo!";
                    $smarty->assign('body', 'alert.tpl');
                    $smarty->assign('success', 1);
                    $smarty->assign('message', $message);
                    header('Refresh: 2; URL=manager-loans.php?pid=1');
                } else {
                    // il servizio non ่ stato creato nel database
                    $message = "Il prestito non e' stato chiuso!";
                    $smarty->assign('body', 'alert.tpl');
                    $smarty->assign('error', 1);
                    $smarty->assign('message', $message);
                    header('Refresh: 2; URL=manager-loans.php?pid=1');
                }
                break;
        }
        break;

    case '3': // ADD LOAN
        if (!isset($_REQUEST['page'])) {
            $page = 0;
        } else {
            $page = $_REQUEST['page'];
        }

        switch ($page) {
            case 0: // DETAIL LOAN
                $isbn = $_GET['isbn'];
                $allVolumes = VolumeService::getAllVolumesByIsbn($isbn);
                $volumes = VolumeService::getAllVolumesAvailableByIsbn($isbn);
                $volumesDisp = UtilsService::filterArraysObject($allVolumes, $volumes);
                $users = UserService::getAllUsers();
                $smarty->assign('body', 'loans-add.tpl');
                $smarty->assign('volumes', $volumesDisp);
                $smarty->assign('users', $users);
                break;

            case 1: // TRANSAZIONE + NOTIFICA (chiusura del prestito)
                $volume = $_REQUEST['volume'];
                $durataMax = $_REQUEST['duratamax'];
                $user = $_REQUEST['utente'];

                //convalida input
                $errori = UtilsService::validate($durataMax, 1, "Durata massima obbligatorio", $errori);

                if (count($errori) == 0) {
                    $dataPrestito = date('Y-m-d');
                    $volume = VolumeService::getVolumeById($volume);
                    $user = UserService::getUserById($user);

                    $loan = new Prestito($id, $durataMax, $dataPrestito, NULL, $volume, $user);

                    $success = LoanService::addLoan($loan);

                    if ($success) {
                        // l'utente รจ stato creato con successo nel database
                        $message = "Il prestito e' stato creato!";
                        $smarty->assign('body', 'alert.tpl');
                        $smarty->assign('success', 1);
                        $smarty->assign('message', $message);
                        header('Refresh: 2; URL=manager-loans.php?pid=1');
                    } else {
                        // l'utente non รจ stato creato nel database
                        $message = "Il prestito non e' stato creato!";
                        $smarty->assign('body', 'alert.tpl');
                        $smarty->assign('error', 1);
                        $smarty->assign('message', $message);
                        header('Refresh: 2; URL=manager-loans.php?pid=1');
                    }
                } else {
                    $smarty->assign('body', 'loans-add.tpl');
                    $message = "Alcuni campi sono obbligatori!";
                    $smarty->assign('warning', 1);
                    $smarty->assign('message', $message);
                    $smarty->assign('errori', $errori);

                    foreach ($_REQUEST as $index => $value) {
                        $smarty->assign($index, $value);
                    }

                    // riscrivo il volume nelle option
                    $selectedVolume = VolumeService::getVolumeById($volume);
                    $array = new ArrayObject;
                    $array->append($selectedVolume);
                    $smarty->assign('selectedVolume', $selectedVolume);
                    $smarty->assign('volumes', UtilsService::filterArraysObject(VolumeService::getAllVolumes(), $array));

                    // riscrivo l'user nelle option
                    $selectedUser = UserService::getUserById($user);
                    $array = new ArrayObject;
                    $array->append($selectedUser);
                    $smarty->assign('selectedUser', $selectedUser);
                    $smarty->assign('users', UtilsService::filterArraysObject(UserService::getAllUsers(), $array));
                }
        }
        break;

    case '4': // UPDATE LOAN
        if (!isset($_REQUEST['page'])) {
            $page = 0;
        } else {
            $page = $_REQUEST['page'];
        }

        switch ($page) {
            case 0: // FORM
                $id = $_GET['id'];
                $loan = LoanService::getLoanById($id);
                
                if ($loan) {
                	$smarty->assign('body', 'loans-update.tpl');
                	
                	$smarty->assign('duratamax', $loan->getDurataMax());
                	
                	$volume = $loan->getVolume();
                	$array = new ArrayObject;
                	$array->append($volume);
                	$smarty->assign('selectedVolume', $volume);
                	
                	$volumesDisp = UtilsService::filterArraysObject(VolumeService::getAllVolumes(), VolumeService::getAllVolumesNotAvailable());
                	
                	$smarty->assign('volumes', $volumesDisp);
                	
                	
                	$user = $loan->getUtente();
                	$array = new ArrayObject;
                	$array->append($user);
                	$smarty->assign('selectedUser', $user);
                	$smarty->assign('users', UtilsService::filterArraysObject(UserService::getAllUsers(), $array));
                	 
                } else {
                	$message = "Impossibile trovare il prestito!";
                	$smarty->assign('body', 'alert.tpl');
                	$smarty->assign('error', 1);
                	$smarty->assign('message', $message);
                	header('Refresh: 2; URL=manager-loans.php');
                }
                
                
                break;

            case 1: // TRANSAZIONE + NOTIFICA
                $id = $_GET['id'];
                $durataMax = $_REQUEST['duratamax'];

                //convalida input
                $errori = UtilsService::validate($durataMax, 1, "Durata max obbligatoria", $errori);

                if (count($errori) == 0) {
                    $old_loan = LoanService::getLoanById($id);

                    $loan = new Prestito($id, $durataMax, $old_loan->getDataPrestito(), $old_loan->getDataRestituzione(), $old_loan->getVolume(), $old_loan->getUtente());

                    $success = LoanService::updateLoan($loan);

                    if ($success) {
                        $message = "Il prestito e' stato modificato con successo!";
                        $smarty->assign('body', 'alert.tpl');
                        $smarty->assign('success', 1);
                        $smarty->assign('message', $message);
                        header('Refresh: 2; URL=manager-loans.php');
                    } else {
                        $message = "Il prestito non e' stato modificato!";
                        $smarty->assign('body', 'alert.tpl');
                        $smarty->assign('error', 1);
                        $smarty->assign('message', $message);
                        header('Refresh: 2; URL=manager-loans.php');
                    }
                } else {
                    $smarty->assign('body', 'loans-add.tpl');
                    $message = "Alcuni campi sono obbligatori!";
                    $smarty->assign('warning', 1);
                    $smarty->assign('message', $message);
                    $smarty->assign('errori', $errori);

                    foreach ($_REQUEST as $index => $value) {
                        $smarty->assign($index, $value);
                    }

                    // riscrivo il volume nelle option
                    $selectedVolume = VolumeService::getVolumeById($volume);
                    $array = new ArrayObject;
                    $array->append($selectedVolume);
                    $smarty->assign('selectedVolume', $selectedVolume);
                    $smarty->assign('volumes', UtilsService::filterArraysObject(VolumeService::getAllVolumes(), $array));

                    // riscrivo l'utente nelle option
                    $selectedUser = UserService::getUserById($utente);
                    $array = new ArrayObject;
                    $array->append($selectedUser);
                    $smarty->assign('selectedUser', $selectedUser);
                    $smarty->assign('users', UtilsService::filterArraysObject(UserService::getAllUsers(), $array));
                }
                break;
        }
        break;

    case '5': // DELETE LOAN
        if (!isset($_REQUEST['page'])) {
            $page = 0;
        } else {
            $page = $_REQUEST['page'];
        }

        switch ($page) {
            case 0: // FORM
                $id = $_GET['id'];
                $loan = LoanService::getLoanById($id);
                if ($loan) {
                	$smarty->assign('body', 'loans-delete.tpl');
                	$smarty->assign('loan', $loan);
                } else {
                	$message = "Impossibile trovare il prestito!";
                	$smarty->assign('body', 'alert.tpl');
                	$smarty->assign('error', 1);
                	$smarty->assign('message', $message);
                	header('Refresh: 2; URL=manager-loans.php');
                }
                break;

            case 1: // TRANSAZIONE + NOTIFICA
                $id = $_GET['id'];
                $loan = LoanService::getLoanById($id);
                $result = LoanService::deleteLoan($loan);
                if ($result) {
                    $message = "Il prestito e' stato eliminato con successo!";
                    $smarty->assign('body', 'alert.tpl');
                    $smarty->assign('success', 1);
                    $smarty->assign('message', $message);
                    header('Refresh: 2; URL=manager-loans.php');
                } else {
                    $message = "Il prestito non e' stato eliminato!";
                    $smarty->assign('body', 'alert.tpl');
                    $smarty->assign('success', 1);
                    $smarty->assign('message', $message);
                    header('Refresh: 2; URL=manager-loans.php');
                }
                break;
        }
        break;

    case '6': // STORICO DEI PRESTITI DI UN PARTICOLARE LIBRO
        $book = BookService::getBookByIsbn($_GET['isbn']);
        if ($book) {
        	$allLoans = LoanService::getAllLoansByBook($book);
        	$smarty->assign('body', 'loans-report.tpl');
        	$smarty->assign('loans', $allLoans);
        	$smarty->assign('date', date('Y-m-d'));
        } else {
        	$message = "Impossibile trovare il libro!";
        	$smarty->assign('body', 'alert.tpl');
        	$smarty->assign('error', 1);
        	$smarty->assign('message', $message);
        	header('Refresh: 2; URL=manager-loans.php');
        }
        
        break;

    default :
        $loans = LoanService::getAllLoans();
        $smarty->assign('body', 'loans-report.tpl');
        $smarty->assign('loans', $loans);
        $smarty->assign('date', date('Y-m-d'));
        break;
}

$smarty->display('backoffice.tpl');
?>