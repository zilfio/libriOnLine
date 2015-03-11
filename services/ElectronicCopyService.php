<?php

include_once 'include/DatabasePDO.php';
require 'model/CopiaElettronica.php';

/**
 * Description of ServiceService
 *
 * @author Zilfio
 */
class ElectronicCopyService {

    public static function getAllElectronicCopies() {
        $database = new DatabasePdo();

        $query = "SELECT * FROM copie_elettroniche";
        $database->query($query);
        $copie = $database->resultset();

        $results = new ArrayObject();
        foreach ($copie as $copia) {
        	$libro = BookService::getBookByIsbn($copia['libro']);
            $result = new CopiaElettronica($copia['id'], $copia['mimetype'],$copia['path'],$libro);
            $results->append($result);
        }
        return $results;
    }
    
    public static function getAllElectronicCopiesByIsbn($isbn) {
    	$database = new DatabasePdo();
    
    	$query = "SELECT * FROM copie_elettroniche WHERE libro=:libro";
    	$database->query($query);
    	$database->bind(':libro', $isbn);
    	$database->execute();
    	$electronicCopies = $database->resultset();
    
    	if ($electronicCopies) {
    		$results = new ArrayObject();
    		foreach ($electronicCopies as $electronicCopy) {
    			$book = BookService::getBookByIsbn($isbn);
    			$result = new CopiaElettronica($electronicCopy['id'], $electronicCopy['mimetype'], $electronicCopy['path'], $book);
    			$results->append($result);
    		}
    		return $results;
    	} else return NULL;
    }
    
    public static function getElectronicCopyById($id) {
    	$database = new DatabasePdo();
    
    	$query = "SELECT * FROM copie_elettroniche WHERE id=:id";
    	$database->query($query);
    	$database->bind(':id', $id);
    	$result = $database->single();
    
    	if($result) {
    		$book = BookService::getBookByIsbn($result['libro']);
    		$electronicCopy = new CopiaElettronica($result['id'], $result['mimetype'], $result['path'], $book);
    		return $electronicCopy;
    	} else return NULL;
    }
    
    public static function insertElectronicCopy(CopiaElettronica $electronicCopy) {
    	$database = new DatabasePdo();
    	
    	$query = "INSERT INTO copie_elettroniche (id, mimetype, path, libro) VALUES (:id, :mimetype, :path, :libro)";
    	$database->query($query);
    	$database->bind(':id', $electronicCopy->getId());
    	$database->bind(':mimetype', $electronicCopy->getMimetype());
    	$database->bind(':path', $electronicCopy->getPath());
    	$database->bind(':libro', $electronicCopy->getLibro()->getIsbn());
    	
    	$database->execute();
    	$result = $database->lastInsertId();
    	
    	return $result;
    }
    
    public static function deleteElectronicCopy(CopiaElettronica $electronicCopy) {
    	$database = new DatabasePdo();

        $query = "DELETE FROM copie_elettroniche WHERE id = :id";
        $database->query($query);
        $database->bind(':id', $electronicCopy->getId());

        $result = $database->execute();

        return $result;
    }

}