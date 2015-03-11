<?php

include_once 'include/DatabasePDO.php';
require 'model/Condizione.php';

/**
 * Description of ServiceService
 *
 * @author Zilfio
 */
class ConditionService {

    public static function getAllConditions() {
        $database = new DatabasePdo();

        $query = "SELECT * FROM condizioni";
        $database->query($query);
        $conditions = $database->resultset();

        $results = new ArrayObject();
        foreach ($conditions as $condition) {
            $result = new Condizione($condition['id'], $condition['nome'], $condition['descrizione']);
            $results->append($result);
        }
        return $results;
    }
    
    public static function getConditionById($id) {
        $database = new DatabasePdo();

        $query = "SELECT * FROM condizioni WHERE id=:id";
        $database->query($query);
        $database->bind(':id', $id);
        $result = $database->single();

        if ($result) {
        	$condition = new Condizione($result['id'], $result['nome'], $result['descrizione']);
        	return $condition;
        } else return NULL;
    }

    public static function insertCondition(Condizione $condition) {
        $database = new DatabasePdo();

        $query = "INSERT INTO condizioni (id, nome, descrizione) VALUES (:id, :nome, :descrizione)";
        $database->query($query);
        $database->bind(':id', $condition->getId());
        $database->bind(':nome', $condition->getNome());
        $database->bind(':descrizione', $condition->getDescrizione());

        $database->execute();
        $result = $database->lastInsertId();

        return $result;
    }

    public static function updateCondition(Condizione $condition) {
        $database = new DatabasePdo();

        $query = "UPDATE condizioni SET nome = :nome, descrizione = :descrizione WHERE id = :id";
        $database->query($query);
        $database->bind(':id', $condition->getId());
        $database->bind(':nome', $condition->getNome());
        $database->bind(':descrizione', $condition->getDescrizione());

        $result = $database->execute();

        return $result;
    }
    
    public static function deleteCondition(Condizione $condition) {
        $database = new DatabasePdo();

        $query = "DELETE FROM condizioni WHERE id = :id";
        $database->query($query);
        $database->bind(':id', $condition->getId());

        $result = $database->execute();
        
        return $result;
    }

}
