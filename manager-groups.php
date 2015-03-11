<?php

session_start();

require "include/config.php";
require "include/auth.inc.php";

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

$action = $_GET['pid'];

switch ($action) {
    case '1': // ADD GROUP
        if (!isset($_REQUEST['page'])) {
            $page = 0;
        } else {
            $page = $_REQUEST['page'];
        }

        switch ($page) {
            case 0: // FORM
                $smarty->assign('body', 'groups-add.tpl');
                $servizi = ServiceService::getAllServices();
                $smarty->assign('servicesNotSel', $servizi);
                break;

            case 1: // TRANSAZIONE + NOTIFICA
                $nome = $_REQUEST['nome'];
                $descrizione = $_REQUEST['descrizione'];
                $servizi = $_REQUEST['servizi'];

                //convalida input
                $errori = UtilsService::validate($nome, 1, "Nome obbligatorio", $errori);

                if (count($errori) == 0) {
                	// verifico che il gruppo non esiste
                	if(GroupService::getGroupByName($nome) == NULL){
                		$gruppo = new Gruppo(NULL, $nome, $descrizione);
                		if ($servizi != NULL) {
                			$services = new ArrayObject();
                			foreach ($servizi as $servizio) {
                				$service = ServiceService::getServiceById($servizio);
                				$services->append($service);
                			}
                			$gruppo->setServizi($services);
                		}
                		$success = intval(GroupService::insertGroup($gruppo));
                		if ($success > 0) { // fai il controllo se è maggiore di 0 direttamente
                			$message = "Il gruppo e' stato creato con successo!";
                			$smarty->assign('body', 'alert.tpl');
                			$smarty->assign('success', 1);
                			$smarty->assign('message', $message);
                			header('Refresh: 2; URL=manager-groups.php');
                		} else {
                			// il gruppo non è stato creato nel database
                			$message = "Il gruppo non e' stato creato!";
                			$smarty->assign('body', 'alert.tpl');
                			$smarty->assign('error', 1);
                			$smarty->assign('message', $message);
                			header('Refresh: 2; URL=manager-groups.php');
                		}
                	} else {
                		$smarty->assign('body', 'groups-add.tpl');
	                    $message = "Nome gi&agrave; esistente!";
	                    $smarty->assign('error', 1);
	                    $smarty->assign('message', $message);
	                    $smarty->assign('errori', $errori);
	                    
	                    foreach ($_REQUEST as $index => $value) {
	                        $smarty->assign($index, $value);
	                    }
	                    
	                    // riscrivo i servizi selezionati nelle option
	                    $services = new ArrayObject;
	                    $servizi = $_REQUEST['servizi'];
	                    if ($servizi != NULL) {
	                        foreach ($servizi as $servizio) {
	                            $services->append(ServiceService::getServiceById($servizio));
	                        }
	                        $smarty->assign('servicesSel', $services);
	                    }
	                    $allServices = ServiceService::getAllServices();
	                    $result = UtilsService::filterArraysObject($allServices, $services);
	                    $smarty->assign('servicesNotSel', $result);
                	}
                    
                } else {
                    $smarty->assign('body', 'groups-add.tpl');
                    $message = "Alcuni campi sono obbligatori!";
                    $smarty->assign('warning', 1);
                    $smarty->assign('message', $message);
                    $smarty->assign('errori', $errori);
                    
                    foreach ($_REQUEST as $index => $value) {
                        $smarty->assign($index, $value);
                    }
                    
                    // riscrivo i servizi selezionati nelle option
                    $services = new ArrayObject;
                    $servizi = $_REQUEST['servizi'];
                    if ($servizi != NULL) {
                        foreach ($servizi as $servizio) {
                            $services->append(ServiceService::getServiceById($servizio));
                        }
                        $smarty->assign('servicesSel', $services);
                    }
                    $allServices = ServiceService::getAllServices();
                    $result = UtilsService::filterArraysObject($allServices, $services);
                    $smarty->assign('servicesNotSel', $result);
                }
                break;
        }
        break;

    case '2': // UPDATE GROUP
        if (!isset($_REQUEST['page'])) {
            $page = 0;
        } else {
            $page = $_REQUEST['page'];
        }

        switch ($page) {
            case 0: // FORM
                $id_gruppo = $_GET['id'];
                $group = GroupService::getGroupById($id_gruppo);
                if($group) {
                	$services = ServiceService::getAllServices();
                	$result = UtilsService::filterArraysObject($services, $group->getServizi());
                	$smarty->assign('body', 'groups-update.tpl');
                	
                	$smarty->assign('nome', $group->getNome());
                	$smarty->assign('descrizione', $group->getDescrizione());
                	
                	$smarty->assign('servicesSel', $group->getServizi());
                	$smarty->assign('servicesNotSel', $result);
                } else {
                	$message = "Impossibile trovare il gruppo!";
                	$smarty->assign('body', 'alert.tpl');
                	$smarty->assign('error', 1);
                	$smarty->assign('message', $message);
                	header('Refresh: 2; URL=manager-groups.php');
                }
                break;

            case 1: // TRANSAZIONE + NOTIFICA
                $id_gruppo = $_GET['id'];
                $nome = $_REQUEST['nome'];
                $descrizione = $_REQUEST['descrizione'];
                $servizi = $_REQUEST['servizi'];

                //convalida input
                $errori = UtilsService::validate($nome, 1, "Nome obbligatorio", $errori);

                if (count($errori) == 0) {
                	$old = GroupService::getGroupById($id_gruppo);
                	
                	if($nome == $old->getNome() || GroupService::getGroupByName($nome) == NULL) {
                		$gruppo = new Gruppo($id_gruppo, $nome, $descrizione);
                		if ($servizi != NULL) {
                			$services = new ArrayObject();
                			foreach ($servizi as $servizio) {
                				$service = ServiceService::getServiceById($servizio);
                				$services->append($service);
                			}
                			$gruppo->setServizi($services);
                		}
                		$result = GroupService::updateGroup($gruppo);
                		if ($result) {
                			$message = "Il gruppo e' stato modificato con successo!";
                			$smarty->assign('body', 'alert.tpl');
                			$smarty->assign('success', 1);
                			$smarty->assign('message', $message);
                			header('Refresh: 2; URL=manager-groups.php');
                		} else {
                			$message = "Il gruppo non e' stato modificato!";
                			$smarty->assign('body', 'alert.tpl');
                			$smarty->assign('error', 1);
                			$smarty->assign('message', $message);
                			header('Refresh: 2; URL=manager-groups.php');
                		}
                	} elseif (GroupService::getGroupByName($nome) != NULL){
                		$smarty->assign('body', 'groups-update.tpl');
                		$message = "Nome esistente!";
                		$smarty->assign('error', 1);
                		$smarty->assign('message', $message);
                		
                		foreach ($_REQUEST as $index => $value) {
                			$smarty->assign($index, $value);
                		}
                		
                		// riscrivo i servizi selezionati nelle option
                		$services = new ArrayObject;
                		$servizi = $_REQUEST['servizi'];
                		if ($servizi != NULL) {
                			foreach ($servizi as $servizio) {
                				$services->append(ServiceService::getServiceById($servizio));
                			}
                			$smarty->assign('servicesSel', $services);
                		}
                		$allServices = ServiceService::getAllServices();
                		$result = UtilsService::filterArraysObject($allServices, $services);
                		$smarty->assign('servicesNotSel', $result);
                	}
                } else {
                    $smarty->assign('body', 'groups-update.tpl');
                    $message = "Alcuni campi sono obbligatori!";
                    $smarty->assign('warning', 1);
                    $smarty->assign('message', $message);

                    foreach ($_REQUEST as $index => $value) {
                        $smarty->assign($index, $value);
                    }
                    
                    // riscrivo i servizi selezionati nelle option
                    $services = new ArrayObject;
                    $servizi = $_REQUEST['servizi'];
                    if ($servizi != NULL) {
                        foreach ($servizi as $servizio) {
                            $services->append(ServiceService::getServiceById($servizio));
                        }
                        $smarty->assign('servicesSel', $services);
                    }
                    $allServices = ServiceService::getAllServices();
                    $result = UtilsService::filterArraysObject($allServices, $services);
                    $smarty->assign('servicesNotSel', $result);
                }
                break;
        }
        break;

    case '3': // DELETE GROUP
        if (!isset($_REQUEST['page'])) {
            $page = 0;
        } else {
            $page = $_REQUEST['page'];
        }

        switch ($page) {
            case 0: // FORM
                $id_gruppo = $_GET['id'];
                $group = GroupService::getGroupById($id_gruppo);
                if($group) {
                	$smarty->assign('body', 'groups-delete.tpl');
                	$smarty->assign('group', $group);
                } else {
                	$message = "Impossibile trovare il gruppo!";
                	$smarty->assign('body', 'alert.tpl');
                	$smarty->assign('error', 1);
                	$smarty->assign('message', $message);
                	header('Refresh: 2; URL=manager-groups.php');
                }
                break;

            case 1: // TRANSAZIONE + NOTIFICA
                $id_gruppo = $_GET['id'];
                $gruppo = GroupService::getGroupById($id_gruppo);
                $result = GroupService::deleteGroup($gruppo);
                if ($result) {
                    $message = "Il gruppo e' stato eliminato con successo!";
                    $smarty->assign('body', 'alert.tpl');
                    $smarty->assign('success', 1);
                    $smarty->assign('message', $message);
                    header('Refresh: 2; URL=manager-groups.php');
                } else {
                    $message = "Il gruppo non e' stato eliminato!";
                    $smarty->assign('body', 'groups-report.tpl');
                    $smarty->assign('body', 'alert.tpl');
                    $smarty->assign('error', 1);
                    $smarty->assign('message', $message);
                    header('Refresh: 2; URL=manager-groups.php');
                }
                break;
        }
        break;

    default:
        $groups = GroupService::getAllGroups();
        $smarty->assign('body', 'groups-report.tpl');
        $smarty->assign('groups', $groups);
        break;
}

$smarty->display('backoffice.tpl');
?>