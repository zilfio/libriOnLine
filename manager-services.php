<?php

session_start();

require "include/config.php";
require "include/auth.inc.php";

include 'services/ServiceService.php';
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
				$smarty->assign('body', 'services-add.tpl');
				break;

			case 1: // TRANSAZIONE + NOTIFICA
				$nome = $_REQUEST['nome'];
				$descrizione = $_REQUEST['descrizione'];
				$script = $_REQUEST['script'];

				//convalida input
				$errori = UtilsService::validate($nome, 1, "Nome obbligatorio", $errori);
				$errori = UtilsService::validate($script, 1, "Script obbligatorio", $errori);

				if(count($errori) == 0) {
					// verifico che il servizio non esiste
					if(ServiceService::getServiceByScript($script) == NULL){
						$servizio = new Servizio($id, $nome, $descrizione, $script);
						$success = intval(ServiceService::insertService($servizio));
						if ($success > 0) { // fai il controllo se è maggiore di 0 direttamente
							// il servizio è stato creato con successo nel database
							$message = "Il servizio e' stato creato con successo!";
							$smarty->assign('body', 'alert.tpl');
							$smarty->assign('success', 1);
							$smarty->assign('message', $message);
							header('Refresh: 2; URL=manager-services.php');
						} else {
							// il servizio non è stato creato nel database
							$message = "Il servizio non e' stato creato!";
							$smarty->assign('body', 'alert.tpl');
							$smarty->assign('error', 1);
							$smarty->assign('message', $message);
							header('Refresh: 2; URL=manager-services.php');
						}
					} else {
						$smarty->assign('body', 'services-add.tpl');
						$message = "Script gi&agrave; esistente!!";
						$smarty->assign('error', 1);
						$smarty->assign('message', $message);
						$smarty->assign('errori', $errori);
						
						foreach ($_REQUEST as $index => $value) {
							$smarty->assign($index, $value);
						}
					}
				} else {
					$smarty->assign('body', 'services-add.tpl');
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
				$id_servizio = $_GET['id'];
				$service = ServiceService::getServiceById($id_servizio);
				if ($service) {
					$smarty->assign('body', 'services-update.tpl');
					$smarty->assign('nome', $service->getNome());
					$smarty->assign('descrizione', $service->getDescrizione());
					$smarty->assign('script', $service->getScript());
				} else {
					$message = "Impossibile trovare il servizio!";
					$smarty->assign('body', 'alert.tpl');
					$smarty->assign('error', 1);
					$smarty->assign('message', $message);
					header('Refresh: 2; URL=manager-services.php');
				}
				break;

			case 1: // TRANSAZIONE + NOTIFICA
				$nome = $_REQUEST['nome'];
				$descrizione = $_REQUEST['descrizione'];
				$script = $_REQUEST['script'];

				//convalida input
				$errori = UtilsService::validate($nome, 1, "Nome obbligatorio", $errori);
				$errori = UtilsService::validate($script, 1, "Script obbligatorio", $errori);

				if(count($errori) == 0) {				
					$id_servizio = $_GET['id'];
					$old = ServiceService::getServiceById($id_servizio);
					
					if($script == $old->getScript() || ServiceService::getServiceByScript($script) == NULL) {
						$servizio = new Servizio($id_servizio, $nome, $descrizione, $script);
						
						$result = ServiceService::updateService($servizio);
						if ($result) {
							$message = "Il servizio e' stato modificato con successo!";
							$smarty->assign('body', 'alert.tpl');
							$smarty->assign('success', 1);
							$smarty->assign('message', $message);
							header('Refresh: 2; URL=manager-services.php');
						} else {
							$message = "Il servizio non e' stato modificato!";
							$smarty->assign('body', 'alert.tpl');
							$smarty->assign('error', 1);
							$smarty->assign('message', $message);
							header('Refresh: 2; URL=manager-services.php');
						}
					} elseif (ServiceService::getServiceByScript($script) != NULL){
						$smarty->assign('body', 'services-update.tpl');
						$message = "Script esistente!";
						$smarty->assign('error', 1);
						$smarty->assign('message', $message);
						$smarty->assign('errori', $errori);
	
						foreach ($_REQUEST as $index => $value) {
							$smarty->assign($index, $value);
						}
					} 
					
				} else {
					$smarty->assign('body', 'services-update.tpl');
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
				$id_servizio = $_GET['id'];
				$service = ServiceService::getServiceById($id_servizio);
				if ($service) {
					$smarty->assign('body', 'services-delete.tpl');
					$smarty->assign('service', $service);
				} else {
					$message = "Impossibile trovare il servizio!";
					$smarty->assign('body', 'alert.tpl');
					$smarty->assign('error', 1);
					$smarty->assign('message', $message);
					header('Refresh: 2; URL=manager-services.php');
				}
				
				break;

			case 1: // TRANSAZIONE + NOTIFICA
				$id_servizio = $_GET['id'];
				$servizio = ServiceService::getServiceById($id_servizio);
				$result = ServiceService::deleteService($servizio);
				if ($result) {
					$message = "Il servizio e' stato eliminato con successo!";
					$smarty->assign('body', 'alert.tpl');
					$smarty->assign('success', 1);
					$smarty->assign('message',$message);
					header('Refresh: 2; URL=manager-services.php');
				} else {
					$message = "Il servizio non e' stato eliminato!";
					$smarty->assign('body', 'alert.tpl');
					$smarty->assign('error', 1);
					$smarty->assign('message',$message);
					header('Refresh: 2; URL=manager-services.php');
				}
				break;
		}
		break;

	default:
		$services = ServiceService::getAllServices();
		$smarty->assign('services', $services);
		$smarty->assign('body', 'services-report.tpl');
		break;
}

$smarty->display('backoffice.tpl');
?>