<?php

session_start();

require "include/config.php";
require "include/auth.inc.php";

include 'services/UserService.php';
include 'services/GroupService.php';
include 'services/ServiceService.php';
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
    case '1': // ADD USER
        if (!isset($_REQUEST['page'])) {
            $page = 0;
        } else {
            $page = $_REQUEST['page'];
        }

        switch ($page) {
            case 0: // FORM
                $smarty->assign('body', 'users-add.tpl');
                $groups = GroupService::getAllGroups();
                $smarty->assign('gruppi', $groups);
                break;

            case 1: // TRANSAZIONE + NOTIFICA

                $username = $_REQUEST['username'];
                $password = $_REQUEST['password'];
                $email = $_REQUEST['email'];
                $telefono = $_REQUEST['telefono'];
                $nome = $_REQUEST['nome'];
                $cognome = $_REQUEST['cognome'];
                $codiceFiscale = $_REQUEST['codicefiscale'];
                $indirizzo = $_REQUEST['indirizzo'];
                $citta = $_REQUEST['citta'];
                $provincia = $_REQUEST['provincia'];
                $cap = $_REQUEST['cap'];
                $gruppi = $_REQUEST['gruppi'];

                //convalida input
                $errori = UtilsService::validate($username, 1, "Username obbligatorio", $errori);
                $errori = UtilsService::validate($password, 1, "Password obbligatoria", $errori);
                $errori = UtilsService::validate($email, 1, "Email obbligatoria", $errori);
                $errori = UtilsService::validate($email, 3, "Email non corretta", $errori);
                $errori = UtilsService::validate($nome, 1, "Nome obbligatorio", $errori);
                $errori = UtilsService::validate($cognome, 1, "Cognome obbligatorio", $errori);
                $errori = UtilsService::validate($codiceFiscale, 1, "Codice fiscale obbligatorio", $errori);
                $errori = UtilsService::validate($codiceFiscale, 2, "Codice fiscale non corretto", $errori);

                if (count($errori) == 0) {

                    if (UserService::verifyExistUsername($username) == FALSE) {
                        // username non ш in uso
                        //$password = UtilsService::generatePassword();

                        // mandare la mail all'indirizzo specificato nel campo email della form
                        // per ora memorizzo la password in un file (password.ini)
                        // $file = 'resources/password.ini';
                        // $person = "$username" . "=" . "$password\n";
                        // file_put_contents($file, $person, FILE_APPEND | LOCK_EX);

                        // creo l'utente nel database
                        $dataRegistrazione = date('Y-m-d H:i:s');
                        $user = new Utente(NULL, $username, md5(md5($password)), $email, $telefono, $nome, $cognome, $codiceFiscale, $indirizzo, $citta, $provincia, $cap, $dataRegistrazione);

                        if ($gruppi != NULL) {
                            $groups = new ArrayObject();
                            foreach ($gruppi as $gruppo) {
                                $group = GroupService::getGroupById($gruppo);
                                $groups->append($group);
                            }
                            $user->setGruppi($groups);
                        }

                        $success = UserService::insertUser($user);

                        if ($success) {
                            // l'utente ш stato creato con successo nel database
                            $message = "L'utente e' stato inserito con successo!";
                            $smarty->assign('body', 'alert.tpl');
                            $smarty->assign('success', 1);
                            $smarty->assign('message', $message);
                            header('Refresh: 2; URL=manager-users.php');
                        } else {
                            // l'utente non ш stato creato nel database
                            $message = "L'utente non e' stato creato!";
                            $smarty->assign('body', 'alert.tpl');
                            $smarty->assign('error', 1);
                            $smarty->assign('message', $message);
                            header('Refresh: 2; URL=manager-users.php');
                        }
                    } else {
                        // l'username ш giра in uso
                        $message = "L'username immesso e' gia' in uso!";
                        $smarty->assign('body', 'users-add.tpl');
                        $smarty->assign('warning', 1);
                        $smarty->assign('message', $message);

                        foreach ($_REQUEST as $index => $value) {
                            $smarty->assign($index, $value);
                        }

                        // riscrivo i gruppi selezionati nelle option
                        $groups = new ArrayObject;
                        $gruppi = $_REQUEST['gruppi'];
                        if ($gruppi != NULL) {
                            foreach ($gruppi as $gruppo) {
                                $groups->append(GroupService::getGroupById($gruppo));
                            }
                            $smarty->assign('gruppiSel', $groups);
                        }
                        $allGroups = GroupService::getAllGroups();
                        $result = UtilsService::filterArraysObject($allGroups, $groups);
                        $smarty->assign('gruppi', $result);
                    }
                } else {
                    $smarty->assign('body', 'users-add.tpl');
                    $message = "Alcuni campi sono obbligatori!";
                    $smarty->assign('warning', 1);
                    $smarty->assign('message', $message);
                    $smarty->assign('errori', $errori);

                    foreach ($_REQUEST as $index => $value) {
                        $smarty->assign($index, $value);
                    }

                    // riscrivo i gruppi selezionati nelle option
                    $groups = new ArrayObject;
                    $gruppi = $_REQUEST['gruppi'];
                    if ($gruppi != NULL) {
                        foreach ($gruppi as $gruppo) {
                            $groups->append(GroupService::getGroupById($gruppo));
                        }
                        $smarty->assign('gruppiSel', $groups);
                    }
                    $allGroups = GroupService::getAllGroups();
                    $result = UtilsService::filterArraysObject($allGroups, $groups);
                    $smarty->assign('gruppi', $result);
                }
        }

        break;

    case '2': // USER UPDATE
        if (!isset($_REQUEST['page'])) {
            $page = 0;
        } else {
            $page = $_REQUEST['page'];
        }

        switch ($page) {
            case 0: // FORM
                $id_user = $_GET['id'];
                $user = UserService::getUserById($id_user);
                
                if($user) {
                	$groups = GroupService::getAllGroups();
                	$result = UtilsService::filterArraysObject($groups, $user->getGruppi());
                	$smarty->assign('body', 'users-update.tpl');
                	
                	$smarty->assign('username', $user->getUsername());
                	$smarty->assign('email', $user->getEmail());
                	$smarty->assign('telefono', $user->getTelefono());
                	$smarty->assign('nome', $user->getNome());
                	$smarty->assign('cognome', $user->getCognome());
                	$smarty->assign('codicefiscale', $user->getCodiceFiscale());
                	$smarty->assign('indirizzo', $user->getIndirizzo());
                	$smarty->assign('citta', $user->getCitta());
                	$smarty->assign('provincia', $user->getProvincia());
                	$smarty->assign('cap', $user->getCap());
                	
                	$smarty->assign('gruppiSel', $user->getGruppi());
                	$smarty->assign('gruppiNotSel', $result);
                } else {
                	$message = "Impossibile trovare l'utente!";
                	$smarty->assign('body', 'alert.tpl');
                	$smarty->assign('error', 1);
                	$smarty->assign('message', $message);
                	header('Refresh: 2; URL=manager-users.php');
                }
                break;

            case 1: // TRANSAZIONE + NOTIFICA
                $id_user = $_GET['id'];
                $username = $_REQUEST['username'];
                $email = $_REQUEST['email'];
                $telefono = $_REQUEST['telefono'];
                $nome = $_REQUEST['nome'];
                $cognome = $_REQUEST['cognome'];
                $codiceFiscale = $_REQUEST['codicefiscale'];
                $indirizzo = $_REQUEST['indirizzo'];
                $citta = $_REQUEST['citta'];
                $provincia = $_REQUEST['provincia'];
                $cap = $_REQUEST['cap'];
                $gruppi = $_REQUEST['gruppi'];

                //convalida input
                $errori = UtilsService::validate($email, 1, "Email obbligatoria", $errori);
                $errori = UtilsService::validate($email, 3, "Email non corretta", $errori);
                $errori = UtilsService::validate($nome, 1, "Nome obbligatorio", $errori);
                $errori = UtilsService::validate($cognome, 1, "Nome obbligatorio", $errori);
                $errori = UtilsService::validate($codiceFiscale, 1, "Codice fiscale obbligatorio", $errori);
                $errori = UtilsService::validate($codiceFiscale, 2, "Codice fiscale non corretto", $errori);

                $old_user = UserService::getUserById($id_user);

                if (count($errori) == 0) {
                    $utente = new Utente($id_user, $username, $old_user->getMd5Password(), $email, $telefono, $nome, $cognome, $codiceFiscale, $indirizzo, $citta, $provincia, $cap, $old_user->getDataRegistrazione());
                    if ($gruppi != NULL) {
                        $groups = new ArrayObject();
                        foreach ($gruppi as $gruppo) {
                            $group = GroupService::getGroupById($gruppo);
                            $groups->append($group);
                        }
                        $utente->setGruppi($groups);
                    }
                    $result = UserService::updateUser($utente);
                    if ($result) {
                        $message = "L'utente e' stato modificato con successo!";
                        $smarty->assign('body', 'alert.tpl');
                        $smarty->assign('success', 1);
                        $smarty->assign('message', $message);
                        header('Refresh: 2; URL=manager-users.php');
                    } else {
                        $message = "L'utente non e' stato modificato!";
                        $smarty->assign('body', 'alert.tpl');
                        $smarty->assign('error', 1);
                        $smarty->assign('message', $message);
                        header('Refresh: 2; URL=manager-users.php');
                    }
                } else {
                    $smarty->assign('body', 'users-update.tpl');
                    $message = "Alcuni campi sono obbligatori!";
                    $smarty->assign('warning', 1);
                    $smarty->assign('message', $message);
                    $smarty->assign('errori', $errori);

                    $id_user = $_GET['id'];
                    $user = UserService::getUserById($id_user);
                    
                    $smarty->assign('username',$user->getUsername());
                    
                    foreach ($_REQUEST as $index => $value) {
                        $smarty->assign($index, $value);
                    }

                    // riscrivo i gruppi nelle option
                    $groups = new ArrayObject;
                    $gruppi = $_REQUEST['gruppi'];
                    if ($gruppi != NULL) {
                        foreach ($gruppi as $gruppo) {
                            $groups->append(GroupService::getGroupById($gruppo));
                        }
                        $smarty->assign('gruppiSel', $groups);
                    }
                    $allGroups = GroupService::getAllGroups();
                    $result = UtilsService::filterArraysObject($allGroups, $groups);
                    $smarty->assign('gruppiNotSel', $result);
                }
                break;
        }
        break;

    case '3': // USER DELETE
        if (!isset($_REQUEST['page'])) {
            $page = 0;
        } else {
            $page = $_REQUEST['page'];
        }

        switch ($page) {
            case 0: // FORM
                $id_utente = $_GET['id'];
                $user = UserService::getUserById($id_utente);
                
                if($user) {
                	$smarty->assign('body', 'users-delete.tpl');
                	$smarty->assign('user', $user);
                } else {
                	$message = "Impossibile trovare l'utente!";
                	$smarty->assign('body', 'alert.tpl');
                	$smarty->assign('error', 1);
                	$smarty->assign('message', $message);
                	header('Refresh: 2; URL=manager-users.php');
                }
                break;

            case 1: // TRANSAZIONE + NOTIFICA
                $id_utente = $_GET['id'];
                $utente = UserService::getUserById($id_utente);
                $result = UserService::deleteUser($utente);
                if ($result) {
                    $message = "L'utente e' stato eliminato con successo!";
                    $smarty->assign('body', 'alert.tpl');
                    $smarty->assign('success', 1);
                    $smarty->assign('message', $message);
                    header('Refresh: 2; URL=manager-users.php');
                } else {
                    $message = "L'utente non e' stato eliminato!";
                    $smarty->assign('body', 'alert.tpl');
                    $smarty->assign('success', 1);
                    $smarty->assign('message', $message);
                    header('Refresh: 2; URL=manager-users.php');
                }
                break;
        }
        break;

    case '4': // UPDATE PASSWORD
        if (!isset($_REQUEST['page'])) {
            $page = 0;
        } else {
            $page = $_REQUEST['page'];
        }

        switch ($page) {
            case 0:
                $smarty->assign('body', 'users-password.tpl');
                break;
            case 1:
                $id_utente = $_GET['id'];
                $password1 = $_REQUEST['password'];
                $password2 = $_REQUEST['password2'];

                //convalida input
                $errori = UtilsService::validate($password1, 1, "Nuova password obbligatoria", $errori);
                $errori = UtilsService::validate($password1, 1, "Ripeti la password", $errori);

                if (count($errori) == 0) {
                    if ($password1 == $password2) {
                        $result = UserService::updatePassword($id_utente, $password1);
                        if ($result) {
                            $message = "La password e' stata modificata con successo!";
                            $smarty->assign('body', 'alert.tpl');
                            $smarty->assign('success', 1);
                            $smarty->assign('message', $message);
                            header('Refresh: 2; URL=manager-users.php');
                        } else {
                            $message = "La password non e' stato modificata!";
                            $smarty->assign('body', 'alert.tpl');
                            $smarty->assign('success', 1);
                            $smarty->assign('message', $message);
                            header('Refresh: 2; URL=manager-users.php');
                        }
                    } else {
                        $message = "Le password devono coincidere!";
                        $smarty->assign('body', 'users-password.tpl');
                        $smarty->assign('warning', 1);
                        $smarty->assign('message', $message);
                    }
                } else {
                    $message = "Inserire la nuova password!";
                    $smarty->assign('body', 'users-password.tpl');
                    $smarty->assign('warning', 1);
                    $smarty->assign('message', $message);
                }
                break;
        }
        break;

    default:
        $users = UserService::getAllUsers();
        $smarty->assign('users', $users);
        $smarty->assign('body', 'users-report.tpl');
        break;
}

$smarty->display('backoffice.tpl');
?>