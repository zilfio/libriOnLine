<?php

include_once 'include/DatabasePDO.php';
require 'model/Autore.php';

/**
 * Description of ServiceService
 *
 * @author Zilfio
 */
class AuthorService {

    public static function getAllAuthors() {
        $database = new DatabasePdo();

        $query = "SELECT * FROM autori";
        $database->query($query);
        $authors = $database->resultset();

        $results = new ArrayObject();
        foreach ($authors as $author) {
            $result = new Autore($author['id'], $author['nome'], $author['cognome']);
            $results->append($result);
        }
        return $results;
    }
    
    public static function getAuthorById($id) {
        $database = new DatabasePdo();

        $query = "SELECT * FROM autori WHERE id=:id";
        $database->query($query);
        $database->bind(':id', $id);
        $result = $database->single();
 		if ($result) {
 			$author = new Autore($result['id'], $result['nome'], $result['cognome']);
 			return $author;
 		} else return NULL;
        
    }
    
    public static function getAuthorsByISBN($isbn) {
        $database = new DatabasePdo();

        $query = "SELECT id,nome,cognome FROM libri_autori join autori on autore=id  WHERE libro=:libro";
        $database->query($query);
        $database->bind(':libro', $isbn);
        $autori = $database->resultset();

        $results = new ArrayObject();
        foreach ($autori as $autore) {
            $result = new Autore($autore['id'], $autore['nome'], $autore['cognome']);
            $results->append($result);
        }
        return $results;
    }

    public static function insertAuthor(Autore $author) {
        $database = new DatabasePdo();

        $query = "INSERT INTO autori (id, nome, cognome) VALUES (:id, :nome, :cognome)";
        $database->query($query);
        $database->bind(':id', $author->getId());
        $database->bind(':nome', $author->getNome());
        $database->bind(':cognome', $author->getCognome());

        $database->execute();
        $result = $database->lastInsertId();

        return $result;
    }

    public static function updateAuthor(Autore $author) {
        $database = new DatabasePdo();

        $query = "UPDATE autori SET nome = :nome, cognome = :cognome WHERE id = :id";
        $database->query($query);
        $database->bind(':id', $author->getId());
        $database->bind(':nome', $author->getNome());
        $database->bind(':cognome', $author->getCognome());

        $result = $database->execute();

        return $result;
    }
    
    public static function deleteAuthor(Autore $author) {
        $database = new DatabasePdo();

        $query = "DELETE FROM autori WHERE id = :id";
        $database->query($query);
        $database->bind(':id', $author->getId());

        $result = $database->execute();
        
        return $result;
    }

}
