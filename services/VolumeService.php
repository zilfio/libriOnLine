<?php

include_once 'include/DatabasePDO.php';
require 'model/Volume.php';

/**
 * Description of VolumeService
 *
 * @author Zilfio
 */
class VolumeService {
    
    public static function getAllVolumes() {
        $database = new DatabasePdo();

        $query = "SELECT * FROM volumi";
        $database->query($query);
        $database->execute();
        $volumes = $database->resultset();

        $results = new ArrayObject();
        foreach ($volumes as $volume) {
            $condizione = ConditionService::getConditionById($volume['condizione']);
            $book = BookService::getBookByIsbn($volume['libro']);
            $result = new Volume($volume['id'], $condizione, $book);
            $results->append($result);
        }
        return $results;
    }
    
    public static function getNumberOfVolumes() {
    	$database = new DatabasePdo();
    
    	$query = "SELECT * FROM volumi";
    	$database->query($query);
    	 
    	$rows = $database->resultset();
    	$result = $database->rowCount();
    
    	return $result;
    }
    
    public static function getAllVolumesNotAvailable() {
        $database = new DatabasePdo();

        $query = "SELECT * FROM prestiti left join volumi ON prestiti.volume = volumi.id WHERE prestiti.datarestituzione IS NULL";
        $database->query($query);
        $database->execute();
        $volumes = $database->resultset();

        $results = new ArrayObject();
        foreach ($volumes as $volume) {
            $condizione = ConditionService::getConditionById($volume['condizione']);
            $book = BookService::getBookByIsbn($volume['libro']);
            $result = new Volume($volume['id'], $condizione, $book);
            $results->append($result);
        }
        return $results;
    }
    
    public static function getAllVolumesByIsbn($isbn) {
        $database = new DatabasePdo();

        $query = "SELECT * FROM volumi WHERE libro=:libro";
        $database->query($query);
        $database->bind(':libro', $isbn);
        $database->execute();
        $volumes = $database->resultset();

        if ($volumes) {
        	$results = new ArrayObject();
        	foreach ($volumes as $volume) {
        		$condizione = ConditionService::getConditionById($volume['condizione']);
        		$book = BookService::getBookByIsbn($isbn);
        		$result = new Volume($volume['id'], $condizione, $book);
        		$results->append($result);
        	}
        	return $results;
        } else return NULL;
    }
    
    public static function getAllVolumesAvailableByIsbn($isbn) {
        $database = new DatabasePdo();

        $query = "SELECT * FROM prestiti left join volumi ON prestiti.volume = volumi.id WHERE volumi.libro=:libro AND prestiti.datarestituzione IS NULL";
        $database->query($query);
        $database->bind(':libro', $isbn);
        $database->execute();
        $volumes = $database->resultset();

        $results = new ArrayObject();
        foreach ($volumes as $volume) {
            $condizione = ConditionService::getConditionById($volume['condizione']);
            $book = BookService::getBookByIsbn($isbn);
            $result = new Volume($volume['id'], $condizione, $book);
            $results->append($result);
        }
        return $results;
    }
    
    public static function getTotalNumberVolumesByIsbn($isbn) {
        $database = new DatabasePdo();

        $query = "SELECT * FROM volumi WHERE libro=:libro";
        $database->query($query);
        $database->bind(':libro', $isbn);
        $database->execute();
        $total = $database->rowCount();
        
        return $total;
    }
    
    public static function getTotalNumberVolumesProvidedByIsbn($isbn) {
        $database = new DatabasePdo();
        
        $query = "SELECT * FROM prestiti left join volumi ON prestiti.volume = volumi.id WHERE volumi.libro=:libro AND prestiti.datarestituzione IS NULL";
        $database->query($query);
        $database->bind(':libro', $isbn);
        $database->execute();
        $total = $database->rowCount();
        
        return $total;
    }
    
    public static function getVolumeById($id) {
        $database = new DatabasePdo();

        $query = "SELECT * FROM volumi WHERE id=:id";
        $database->query($query);
        $database->bind(':id', $id);
        $result = $database->single();

        if ($result) {
        	$condizione = ConditionService::getConditionById($result['condizione']);
        	$libro = BookService::getBookByIsbn($result['libro']);
        	$volume = new Volume($result['id'], $condizione, $libro);
        	
        	return $volume;
        } else return NULL;
        
    }
    
    public static function insertVolume (Volume $volume, $copie) {
        $database = new DatabasePdo();

        try {

            $database->beginTransaction();
        
            $query = "INSERT INTO volumi (id, condizione, libro) VALUES (:id, :condizione, :libro)";
            $database->query($query);
            $database->bind(':id', $volume->getId());
            $database->bind(':condizione', $volume->getCondizione()->getId());
            $database->bind(':libro', $volume->getLibro()->getIsbn());

            while ($copie > 0){
                $database->execute();
                $copie--;
            }
            
            return $database->endTransaction();
        } catch (Exception $exc) {

            echo $exc->getTraceAsString();

            $database->cancelTransaction();
        }
    }
    
    public static function updateVolume(Volume $volume) {
        $database = new DatabasePdo();
        
        $query = "UPDATE volumi SET condizione = :condizione WHERE id = :id";
        $database->query($query);
        $database->bind(':id', $volume->getId());
        $database->bind(':condizione', $volume->getCondizione()->getId());

        $result = $database->execute();

        return $result;
    }


    public static function deleteVolume(Volume $volume) {
        $database = new DatabasePdo();

        $query = "DELETE FROM volumi WHERE id = :id";
        $database->query($query);
        $database->bind(':id', $volume->getId());

        $result = $database->execute();

        return $result;
    }
}

?>