<?php

include_once 'include/DatabasePDO.php';
require 'model/Editore.php';

/**
 * Description of ServiceService
 *
 * @author Zilfio
 */
class EditorService {

    public static function getAllEditors() {
        $database = new DatabasePdo();

        $query = "SELECT * FROM editori";
        $database->query($query);
        $editori = $database->resultset();

        $results = new ArrayObject();
        foreach ($editori as $editore) {
            $result = new Editore($editore['id'], $editore['nome']);
            $results->append($result);
        }
        return $results;
    }
    
    public static function getEditorById($id) {
        $database = new DatabasePdo();

        $query = "SELECT * FROM editori WHERE id=:id";
        $database->query($query);
        $database->bind(':id', $id);
        $result = $database->single();

        if($result) {
        	$editore = new Editore($result['id'], $result['nome']);
        	return $editore;
        } else return NULL;
        
    }


    public static function insertEditor(Editore $editore) {
        $database = new DatabasePdo();

        $query = "INSERT INTO editori (id, nome) VALUES (:id, :nome)";
        $database->query($query);
        $database->bind(':id', $editore->getId());
        $database->bind(':nome', $editore->getNome());
        
        $database->execute();
        $result = $database->lastInsertId();

        return $result;
    }

    public static function updateEditor(Editore $editore) {
        $database = new DatabasePdo();

        $query = "UPDATE editori SET nome = :nome WHERE id = :id";
        $database->query($query);
        $database->bind(':id', $editore->getId());
        $database->bind(':nome', $editore->getNome());

        $result = $database->execute();

        return $result;
    }
    
    public static function deleteEditor(Editore $editore) {
        $database = new DatabasePdo();

        $query = "DELETE FROM editori WHERE id = :id";
        $database->query($query);
        $database->bind(':id', $editore->getId());

        $result = $database->execute();
        
        return $result;
    }

}