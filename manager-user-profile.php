<?php

session_start();

require "include/config.php";
require "include/auth.inc.php";

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

$errori = array();

if (!isset($_REQUEST['page'])) {
	$page = 0;
} else {
	$page = $_REQUEST['page'];
}

switch ($page) {
	case 0: // FORM
		$user = UserService::getUserById($_SESSION['user']['id']);
		$smarty->assign('body', 'user-profile-update.tpl');
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
		break;
		
	case 1: // TRANSAZIONE + NOTIFICA
		$id_user = $_SESSION['user']['id'];
		$email = $_REQUEST['email'];
		$telefono = $_REQUEST['telefono'];
		$nome = $_REQUEST['nome'];
		$cognome = $_REQUEST['cognome'];
		$codiceFiscale = $_REQUEST['codicefiscale'];
		$indirizzo = $_REQUEST['indirizzo'];
		$citta = $_REQUEST['citta'];
		$provincia = $_REQUEST['provincia'];
		$cap = $_REQUEST['cap'];
		
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
			$result = UserService::updateUserProfile($utente);
			if ($result) {
				$message = "L'utente e' stato modificato con successo!";
				$smarty->assign('body', 'alert.tpl');
				$smarty->assign('success', 1);
				$smarty->assign('message', $message);
				header('Refresh: 2; URL=backoffice.php');
			} else {
				$message = "L'utente non e' stato modificato!";
				$smarty->assign('body', 'alert.tpl');
				$smarty->assign('error', 1);
				$smarty->assign('message', $message);
				header('Refresh: 2; URL=backoffice.php');
			}
		} else {
			$smarty->assign('body', 'user-profile-update.tpl');
			$message = "Alcuni campi sono obbligatori!";
			$smarty->assign('warning', 1);
			$smarty->assign('message', $message);
			$smarty->assign('errori', $errori);
			
			$user = UserService::getUserById($_SESSION['user']['id']);
			$smarty->assign('username', $user->getUsername());
			
			foreach ($_REQUEST as $index => $value) {
				$smarty->assign($index, $value);
			}
		}
		break;
}

$smarty->display('backoffice.tpl');

?>