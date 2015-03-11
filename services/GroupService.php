<?php

include_once 'include/DatabasePDO.php';
require 'model/Gruppo.php';

/**
 * Description of GroupService
 *
 * @author Zilfio
 */
class GroupService {

    /**
     * 
     * @return \ArrayObject
     */
    public static function getAllGroups() {
        $database = new DatabasePdo();

        $query = "SELECT * FROM gruppi";
        $database->query($query);
        $groups = $database->resultset();

        $results = new ArrayObject();
        foreach ($groups as $group) {
            $result = new Gruppo($group['id'], $group['nome'], $group['descrizione']);
            $results->append($result);
        }
        return $results;
    }

    public static function getGroupById($id) {
        $database = new DatabasePdo();

        $query = "SELECT * FROM gruppi WHERE id=:id";
        $database->query($query);
        $database->bind(':id', $id);
        $result = $database->single();

        if($result) {
        	$group = new Gruppo($result['id'], $result['nome'], $result['descrizione']);
        	$group->setServizi(ServiceService::getServicesByIdGroup($id));
        	return $group;
        } else return NULL;
        
    }
    
    public static function getGroupByName($name) {
    	$database = new DatabasePdo();
    
    	$query = "SELECT * FROM gruppi WHERE nome=:nome";
    	$database->query($query);
    	$database->bind(':nome', $name);
    	$result = $database->single();
    
    	if($result) {
    		$group = new Gruppo($result['id'], $result['nome'], $result['descrizione']);
    		$group->setServizi(ServiceService::getServicesByIdGroup($id));
    		return $group;
    	} else return NULL;
    
    }

    public static function getGroupsByUserId($id) {
        $database = new DatabasePdo();

        $query = "SELECT id,nome,descrizione FROM utenti_gruppi join gruppi on id_gruppo=id  WHERE id_utente=:utenteId";
        $database->query($query);
        $database->bind(':utenteId', $id);
        $groups = $database->resultset();

        $results = new ArrayObject();
        foreach ($groups as $group) {
            $result = new Gruppo($group['id'], $group['nome'], $group['descrizione']);
            $results->append($result);
        }
        return $results;
    }

    public static function insertGroup(Gruppo $gruppo) {
        $database = new DatabasePdo();

        try {

            $database->beginTransaction();

            $query = "INSERT INTO gruppi (id, nome, descrizione) VALUES (:id, :nome, :descrizione)";
            $database->query($query);
            $database->bind(':id', NULL);
            $database->bind(':nome', $gruppo->getNome());
            $database->bind(':descrizione', $gruppo->getDescrizione());

            $database->execute();
            $id_gruppo = $database->lastInsertId();

            $servizi = $gruppo->getServizi();
            if ($servizi != NULL) {
                foreach ($servizi as $servizio) {
                    $query = "INSERT INTO gruppi_servizi (id_gruppo, id_servizio) VALUES (:id_gruppo, :id_servizio)";
                    $database->query($query);
                    $database->bind(':id_gruppo', $id_gruppo);
                    $database->bind(':id_servizio', $servizio->getId());
                    $database->execute();
                }
            }

            return $database->endTransaction();
        } catch (Exception $exc) {

            echo $exc->getTraceAsString();

            $database->cancelTransaction();
        }
    }

    public static function updateGroup(Gruppo $gruppo) {
        $database = new DatabasePdo();

        try {

            $database->beginTransaction();

            $query = "UPDATE gruppi SET nome = :nome, descrizione = :descrizione WHERE id = :id";
            $database->query($query);
            $database->bind(':id', $gruppo->getId());
            $database->bind(':nome', $gruppo->getNome());
            $database->bind(':descrizione', $gruppo->getDescrizione());

            $database->execute();

            $query = "DELETE FROM gruppi_servizi WHERE id_gruppo = :id";
            $database->query($query);
            $database->bind(':id', $gruppo->getId());

            $database->execute();

            $servizi = $gruppo->getServizi();
            if ($servizi != NULL) {
                foreach ($servizi as $servizio) {
                    $query = "INSERT INTO gruppi_servizi (id_gruppo, id_servizio) VALUES (:id_gruppo, :id_servizio)";
                    $database->query($query);
                    $database->bind(':id_gruppo', $gruppo->getId());
                    $database->bind(':id_servizio', $servizio->getId());

                    $database->execute();
                }
            }

            return $database->endTransaction();
        } catch (Exception $exc) {

            echo $exc->getTraceAsString();

            $database->cancelTransaction();
        }
    }

    public static function deleteGroup(Gruppo $gruppo) {
        $database = new DatabasePdo();

        $query = "DELETE FROM gruppi WHERE id = :id";
        $database->query($query);
        $database->bind(':id', $gruppo->getId());

        $result = $database->execute();

        return $result;
    }

}

?>