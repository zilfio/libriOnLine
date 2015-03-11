<?php

include_once 'include/DatabasePDO.php';
require 'model/Prestito.php';

/**
 * Description of LoanService
 *
 * @author Zilfio
 */
class LoanService {
    
    public static function getAllLoans() {
        $database = new DatabasePdo();

        $query = "SELECT * FROM prestiti";
        $database->query($query);
        $prestiti = $database->resultset();

        $results = new ArrayObject();
        foreach ($prestiti as $prestito) {
            $result = new Prestito($prestito['id'], $prestito['duratamax'], $prestito['dataprestito'], $prestito['datarestituzione'], VolumeService::getVolumeById($prestito['volume']), UserService::getUserById($prestito['utente']));
            $results->append($result);
        }
        return $results;
    }
    
    public static function getNumberOfLoans() {
    	$database = new DatabasePdo();
    
    	$query = "SELECT * FROM prestiti";
    	$database->query($query);
    
    	$rows = $database->resultset();
    	$result = $database->rowCount();
    
    	return $result;
    }
    
    public static function getNumberOfActiveLoans() {
    	$database = new DatabasePdo();
    
    	$query = "SELECT * FROM prestiti where datarestituzione is null";
    	$database->query($query);
    
    	$rows = $database->resultset();
    	$result = $database->rowCount();
    
    	return $result;
    }
    
    public static function getAllLoansByBook(Libro $book) {
    	$database = new DatabasePdo();
    
    	$query = "SELECT prestiti.* FROM prestiti INNER JOIN volumi ON prestiti.volume = volumi.id INNER JOIN libri ON volumi.libro = libri.isbn WHERE libri.isbn = :isbn";
    	$database->query($query);
    	$database->bind(':isbn', $book->getIsbn());
    	$prestiti = $database->resultset();
    
    	$results = new ArrayObject();
    	foreach ($prestiti as $prestito) {
    		$result = new Prestito($prestito['id'], $prestito['duratamax'], $prestito['dataprestito'], $prestito['datarestituzione'], VolumeService::getVolumeById($prestito['volume']), UserService::getUserById($prestito['utente']));
    		$results->append($result);
    	}
    	return $results;
    }
    
    public static function getAllLoansByUser(Utente $utente) {
        $database = new DatabasePdo();

        $query = "SELECT * FROM prestiti WHERE utente = :utente";
        $database->query($query);
        $database->bind(':utente', $utente->getId());
        $prestiti = $database->resultset();

        $results = new ArrayObject();
        foreach ($prestiti as $prestito) {
            $result = new Prestito($prestito['id'], $prestito['duratamax'], $prestito['dataprestito'], $prestito['datarestituzione'], VolumeService::getVolumeById($prestito['volume']), UserService::getUserById($prestito['utente']));
            $results->append($result);
        }
        return $results;
    }
    
    public static function getAllActiveLoan() {
        $database = new DatabasePdo();

        $query = "SELECT * FROM prestiti WHERE prestiti.datarestituzione IS NULL";
        $database->query($query);
        $prestiti = $database->resultset();

        $results = new ArrayObject();
        foreach ($prestiti as $prestito) {
            $result = new Prestito($prestito['id'], $prestito['duratamax'], $prestito['dataprestito'], $prestito['datarestituzione'], VolumeService::getVolumeById($prestito['volume']), UserService::getUserById($prestito['utente']));
            $results->append($result);
        }
        return $results;
    }
    
    public static function getAllActiveLoanByUser(Utente $utente) {
        $database = new DatabasePdo();

        $query = "SELECT * FROM prestiti WHERE utente = :utente AND prestiti.datarestituzione IS NULL";
        $database->query($query);
        $database->bind(':utente', $utente->getId());
        $prestiti = $database->resultset();

        $results = new ArrayObject();
        foreach ($prestiti as $prestito) {
            $result = new Prestito($prestito['id'], $prestito['duratamax'], $prestito['dataprestito'], $prestito['datarestituzione'], VolumeService::getVolumeById($prestito['volume']), UserService::getUserById($prestito['utente']));
            $results->append($result);
        }
        return $results;
    }
    
    public static function getLoanById($id) {
        $database = new DatabasePdo();

        $query = "SELECT * FROM prestiti WHERE id=:id";
        $database->query($query);
        $database->bind(':id', $id);
        $result = $database->single();

        if ($result) {
        	$volume = VolumeService::getVolumeById($result['volume']);
        	$utente = UserService::getUserById($result['utente']);
        	$book = new Prestito($result['id'], $result['duratamax'], $result['dataprestito'], $result['$datarestituzione'], $volume, $utente);
        	return $book;
        } else return NULL;
        
    }
    
    public static function addLoan(Prestito $loan) {
        $database = new DatabasePdo();
        
        $query = "INSERT INTO prestiti (id, volume, duratamax, dataprestito, datarestituzione, utente) VALUES (:id, :volume, :duratamax, :dataprestito, :datarestituzione, :utente)";
        $database->query($query);
        $database->bind(':id', $loan->getId());
        $database->bind(':volume', $loan->getVolume()->getId());
        $database->bind(':duratamax', $loan->getDurataMax());
        $database->bind(':dataprestito', $loan->getDataPrestito());
        $database->bind(':datarestituzione', $loan->getDataRestituzione());
        $database->bind(':utente', $loan->getUtente()->getId());

        $database->execute();
        $result = $database->lastInsertId();

        return $result;
    }
    
    public static function closeLoan($loan,$date) {
        $database = new DatabasePdo();
        
        $query = "UPDATE prestiti SET datarestituzione = :datarestituzione WHERE id = :id";
        $database->query($query);
        $database->bind(':id', $loan->getId());
        $database->bind(':datarestituzione', $date);

        $result = $database->execute();

        return $result;
    }
    
    public static function updateLoan(Prestito $prestito) {
        $database = new DatabasePdo();
        
        $query = "UPDATE prestiti SET volume = :volume, duratamax = :duratamax, utente = :utente WHERE id = :id";
        $database->query($query);
        $database->bind(':id', $prestito->getId());
        $database->bind(':volume', $prestito->getVolume()->getId());
        $database->bind(':duratamax', $prestito->getDurataMax());
        $database->bind(':utente', $prestito->getUtente()->getId());

        $result = $database->execute();

        return $result;
    }
    
    public static function deleteLoan(Prestito $loan) {
        $database = new DatabasePdo();

        $query = "DELETE FROM prestiti WHERE id = :id";
        $database->query($query);
        $database->bind(':id', $loan->getId());

        $result = $database->execute();
        
        return $result;
    }
    
}
