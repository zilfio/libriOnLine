<?php

include_once 'include/DatabasePDO.php';
require 'model/Tag.php';

/**
 * Description of ServiceService
 *
 * @author Zilfio
 */
class TagService {

    public static function getAllTags() {
        $database = new DatabasePdo();

        $query = "SELECT * FROM tags";
        $database->query($query);
        $tags = $database->resultset();

        $results = new ArrayObject();
        foreach ($tags as $tag) {
            $result = new Tag($tag['id'], $tag['nome']);
            $results->append($result);
        }
        return $results;
    }
    
    public static function getTagById($id) {
        $database = new DatabasePdo();

        $query = "SELECT * FROM tags WHERE id=:id";
        $database->query($query);
        $database->bind(':id', $id);
        $result = $database->single();

        if($result) {
        	$tag = new Tag($result['id'], $result['nome']);
        	return $tag;
        } else return NULL;
        
    }

    public static function getTagsByISBN($isbn) {
        $database = new DatabasePdo();

        $query = "SELECT id,nome FROM libri_tags join tags on tag=id  WHERE libro=:libro";
        $database->query($query);
        $database->bind(':libro', $isbn);
        $tags = $database->resultset();

        $results = new ArrayObject();
        foreach ($tags as $tag) {
            $result = new Tag($tag['id'], $tag['nome']);
            $results->append($result);
        }
        return $results;
    }

    public static function insertTag(Tag $tag) {
        $database = new DatabasePdo();

        $query = "INSERT INTO tags (id, nome) VALUES (:id, :nome)";
        $database->query($query);
        $database->bind(':id', $tag->getId());
        $database->bind(':nome', $tag->getNome());
        
        $database->execute();
        $result = $database->lastInsertId();

        return $result;
    }

    public static function updateTag(Tag $tag) {
        $database = new DatabasePdo();

        $query = "UPDATE tags SET nome = :nome WHERE id = :id";
        $database->query($query);
        $database->bind(':id', $tag->getId());
        $database->bind(':nome', $tag->getNome());

        $result = $database->execute();

        return $result;
    }
    
    public static function deleteTag(Tag $tag) {
        $database = new DatabasePdo();

        $query = "DELETE FROM tags WHERE id = :id";
        $database->query($query);
        $database->bind(':id', $tag->getId());

        $result = $database->execute();
        
        return $result;
    }

}