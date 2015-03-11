<?php

include_once 'include/DatabasePDO.php';
require 'model/Servizio.php';

/**
 * Description of ServiceService
 *
 * @author Zilfio
 */
class ServiceService {

    public static function getAllServices() {
        $database = new DatabasePdo();

        $query = "SELECT * FROM servizi";
        $database->query($query);
        $services = $database->resultset();

        $results = new ArrayObject();
        foreach ($services as $service) {
            $result = new Servizio($service['id'], $service['nome'], $service['descrizione'], $service['script']);
            $results->append($result);
        }
        return $results;
    }
    
    public static function getServiceById($id) {
        $database = new DatabasePdo();

        $query = "SELECT * FROM servizi WHERE id=:id";
        $database->query($query);
        $database->bind(':id', $id);
        $result = $database->single();

        if($result) {
        	return new Servizio($result['id'], $result['nome'], $result['descrizione'], $result['script']);
        } else return NULL;
        
    }

    public static function getServiceByScript($script) {
    	$database = new DatabasePdo();
    
    	$query = "SELECT * FROM servizi WHERE script=:script";
    	$database->query($query);
    	$database->bind(':script', $script);
    	$result = $database->single();
    
    	if($result) {
        	return new Servizio($result['id'], $result['nome'], $result['descrizione'], $result['script']);
        } else return NULL;
    }
    
    public static function getServicesByUsername($username) {
        $database = new DatabasePdo();

        $query = "select distinct servizi.script from utenti 
                            left join utenti_gruppi
                            on utenti.id=utenti_gruppi.id_utente
                            left join gruppi
                            on gruppi.id = utenti_gruppi.id_gruppo
                            left join gruppi_servizi
                            on gruppi_servizi.id_gruppo=gruppi.id
                            left join servizi
                            on servizi.id = gruppi_servizi.id_servizio
                            where utenti.username = :username";
        $database->query($query);
        $database->bind(':username', $username);
        $services = $database->resultset2();

        return $services;
    }

    public static function getServicesByIdGroup($id_group) {
        $database = new DatabasePdo();
        
        $query = "SELECT id,nome,descrizione,script FROM `gruppi_servizi` join servizi ON id_servizio=id WHERE id_gruppo=:id_gruppo";
        $database->query($query);
        $database->bind(':id_gruppo', $id_group);
        $services = $database->resultset();

        $results = new ArrayObject();
        foreach ($services as $service) {
            $result = new Servizio($service['id'], $service['nome'], $service['descrizione'], $service['script']);
            $results->append($result);
        }
        return $results;
    }


    public static function insertService(Servizio $service) {
        $database = new DatabasePdo();

        $query = "INSERT INTO servizi (id, nome, descrizione, script) VALUES (:id, :nome, :descrizione, :script)";
        $database->query($query);
        $database->bind(':id', $service->getId());
        $database->bind(':nome', $service->getNome());
        $database->bind(':descrizione', $service->getDescrizione());
        $database->bind(':script', $service->getScript());

        $database->execute();
        $result = $database->lastInsertId();

        return $result;
    }

    public static function updateService(Servizio $service) {
        $database = new DatabasePdo();

        $query = "UPDATE servizi SET nome = :nome, descrizione = :descrizione, script = :script WHERE id = :id";
        $database->query($query);
        $database->bind(':id', $service->getId());
        $database->bind(':nome', $service->getNome());
        $database->bind(':descrizione', $service->getDescrizione());
        $database->bind(':script', $service->getScript());

        $result = $database->execute();

        return $result;
    }
    
    public static function deleteService(Servizio $servizio) {
        $database = new DatabasePdo();

        $query = "DELETE FROM servizi WHERE id = :id";
        $database->query($query);
        $database->bind(':id', $servizio->getId());

        $result = $database->execute();
        
        return $result;
    }

}
