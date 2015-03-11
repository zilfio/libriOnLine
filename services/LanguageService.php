<?php

include_once 'include/DatabasePDO.php';
require 'model/Lingua.php';

/**
 * Description of ServiceService
 *
 * @author Zilfio
 */
class LanguageService {

    public static function getAllLanguages() {
        $database = new DatabasePdo();

        $query = "SELECT * FROM lingue";
        $database->query($query);
        $lingue = $database->resultset();

        $results = new ArrayObject();
        foreach ($lingue as $lingua) {
            $result = new Lingua($lingua['id'], $lingua['nome']);
            $results->append($result);
        }
        return $results;
    }
    
    public static function getLanguageById($id) {
        $database = new DatabasePdo();

        $query = "SELECT * FROM lingue WHERE id=:id";
        $database->query($query);
        $database->bind(':id', $id);
        $result = $database->single();

        if ($result) {
        	$lingua = new Lingua($result['id'], $result['nome']);
        	return $lingua;
        } else return NULL;

    }


    public static function insertLanguage(Lingua $language) {
        $database = new DatabasePdo();

        $query = "INSERT INTO lingue (id, nome) VALUES (:id, :nome)";
        $database->query($query);
        $database->bind(':id', $language->getId());
        $database->bind(':nome', $language->getNome());
        
        $database->execute();
        $result = $database->lastInsertId();

        return $result;
    }

    public static function updateLanguage(Lingua $language) {
        $database = new DatabasePdo();

        $query = "UPDATE lingue SET nome = :nome WHERE id = :id";
        $database->query($query);
        $database->bind(':id', $language->getId());
        $database->bind(':nome', $language->getNome());

        $result = $database->execute();

        return $result;
    }
    
    public static function deleteLanguage(Lingua $language) {
        $database = new DatabasePdo();

        $query = "DELETE FROM lingue WHERE id = :id";
        $database->query($query);
        $database->bind(':id', $language->getId());

        $result = $database->execute();
        
        return $result;
    }

}