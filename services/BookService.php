<?php

include_once 'include/DatabasePDO.php';
require 'model/Libro.php';

require_once 'services/EditorService.php';
require_once 'services/LanguageService.php';

/**
 * Description of ServiceService
 *
 * @author Zilfio
 */
class BookService {

    public static function getAllBooks() {
        $database = new DatabasePdo();

        $query = "SELECT * FROM libri order by titolo asc";
        $database->query($query);
        $books = $database->resultset();

        $results = new ArrayObject();
        foreach ($books as $book) {
            $editor = EditorService::getEditorById($book['editore']);
            $language = LanguageService::getLanguageById($book['lingua']);
            $result = new Libro($book['isbn'], $book['titolo'], $editor, $book['annopubblicazione'], $book['recensione'], $language, $book['datainserimento'],$book['copertina']);
            $results->append($result);
        }
        return $results;
    }
    
    public static function getOtherBooks(Libro $book) {
    	$database = new DatabasePdo();
    
    	$query = "SELECT * FROM libri WHERE isbn <> :isbn order by rand() LIMIT 0,4";
    	$database->query($query);
    	$database->bind(':isbn', $book->getIsbn());
    	$books = $database->resultset();
    
    	$results = new ArrayObject();
    	foreach ($books as $book) {
    		$editor = EditorService::getEditorById($book['editore']);
    		$language = LanguageService::getLanguageById($book['lingua']);
    		$result = new Libro($book['isbn'], $book['titolo'], $editor, $book['annopubblicazione'], $book['recensione'], $language, $book['datainserimento'],$book['copertina']);
    		$results->append($result);
    	}
    	return $results;
    }
    
    public static function getAllBooksByAuthor(Autore $autore) {
    	$database = new DatabasePdo();
    	
    	$query = "SELECT * FROM libri INNER JOIN libri_autori ON libri.isbn = libri_autori.libro WHERE libri_autori.autore = :autore";
    	$database->query($query);
    	$database->bind(':autore', $autore->getId());
    	$books = $database->resultset();
    	
    	$results = new ArrayObject();
    	foreach ($books as $book) {
    		$editor = EditorService::getEditorById($book['editore']);
    		$language = LanguageService::getLanguageById($book['lingua']);
    		$result = new Libro($book['isbn'], $book['titolo'], $editor, $book['annopubblicazione'], $book['recensione'], $language, $book['datainserimento'],$book['copertina']);
    		$results->append($result);
    	}
    	return $results;
    }
    
    public static function getAllBooksByTag(Tag $tag) {
    	$database = new DatabasePdo();
    	 
    	$query = "SELECT * FROM libri INNER JOIN libri_tags ON libri.isbn = libri_tags.libro WHERE libri_tags.tag = :tag";
    	$database->query($query);
    	$database->bind(':tag', $tag->getId());
    	$books = $database->resultset();
    	 
    	$results = new ArrayObject();
    	foreach ($books as $book) {
    		$editor = EditorService::getEditorById($book['editore']);
    		$language = LanguageService::getLanguageById($book['lingua']);
    		$result = new Libro($book['isbn'], $book['titolo'], $editor, $book['annopubblicazione'], $book['recensione'], $language, $book['datainserimento'],$book['copertina']);
    		$results->append($result);
    	}
    	return $results;
    }
    
    public static function getAllBooksLikeTitle($title) {
    	$database = new DatabasePdo();
    	
    	$query = "SELECT * FROM libri WHERE titolo LIKE '%$title%'";
    	$database->query($query);
    	$books = $database->resultset();
    	
    	$results = new ArrayObject();
    	foreach ($books as $book) {
    		$editor = EditorService::getEditorById($book['editore']);
    		$language = LanguageService::getLanguageById($book['lingua']);
    		$result = new Libro($book['isbn'], $book['titolo'], $editor, $book['annopubblicazione'], $book['recensione'], $language, $book['datainserimento'],$book['copertina']);
    		$results->append($result);
    	}
    	return $results;
    }
    
    public static function getAllBooksAdvancedSearch() {
    	$isbn = $_POST['isbn'];
    	$titolo = $_POST['titolo'];
    	$typeSearchTitolo = $_POST['typeSearchTitolo'];
    	
    	$autori = $_POST['autori'];
    	$tags = $_POST['tags'];
    	
    	$language = $_POST['lingua'];
    	
    	$were = "WHERE";
    	if(isset($isbn) && strlen($isbn) > 0) {
    		$were .= " isbn= '$isbn' AND";
    	}
    	
    	if(isset($titolo) && strlen($titolo) > 0) {
    		if(isset($typeSearchTitolo) && $typeSearchTitolo == '1') {
    			$were .= " titolo LIKE '%$titolo%' AND";
    		}
    		 elseif(isset($typeSearchTitolo) && $typeSearchTitolo == '2') {
    		 	$were .= " titolo= '$titolo' AND";
    		}
    	}
    	
    	if (isset($autori)) {
    		$join_authors = "INNER JOIN libri_autori on libri.isbn=libri_autori.libro";
    		foreach ($autori as $autore) {
    			$were .= " libri_autori.autore = $autore AND";
    		}
    	}
    	
    	if (isset($tags)) {
    		$join_tags = "INNER JOIN libri_tags on libri.isbn=libri_tags.libro";
    		foreach ($tags as $tag) {
    			$were .= " libri_tags.tag = $tag AND";
    		}
    	}
    	
    	if(isset($language) && $language != '0') {
    		$were .= " lingua= '$language' AND";
    	}
    	
    	$were .= " 1=1";
    	
    	$database = new DatabasePdo();
    	 
    	$query = "SELECT * FROM libri $join_authors $join_tags $were";
    	
    	$database->query($query);
    	$books = $database->resultset();
    	
    	$results = new ArrayObject();
    	foreach ($books as $book) {
    		$editor = EditorService::getEditorById($book['editore']);
    		$language = LanguageService::getLanguageById($book['lingua']);
    		$result = new Libro($book['isbn'], $book['titolo'], $editor, $book['annopubblicazione'], $book['recensione'], $language, $book['datainserimento'],$book['copertina']);
    		$results->append($result);
    	}
    	return $results;
    }
    
    public static function getNumberOfBooks() {
    	$database = new DatabasePdo();
    
    	$query = "SELECT * FROM libri";
    	$database->query($query);
    	
    	$rows = $database->resultset();
    	$result = $database->rowCount();

    	return $result;
    }
    
    public static function getLastBooks() {
    	$database = new DatabasePdo();
    	
    	$query = "select * from libri order by datainserimento desc LIMIT 0,4";
    	$database->query($query);
    	$books = $database->resultset();
    	
    	$results = new ArrayObject();
    	foreach ($books as $book) {
    		$editor = EditorService::getEditorById($book['editore']);
    		$language = LanguageService::getLanguageById($book['lingua']);
    		$result = new Libro($book['isbn'], $book['titolo'], $editor, $book['annopubblicazione'], $book['recensione'], $language, $book['datainserimento'],$book['copertina']);
    		$results->append($result);
    	}
    	return $results;
    }
    
    /**
     * Restituisce la data presunta di restituzione del primo libro
     * @param unknown $isbn
     * @return Ambigous <type, mixed>
     */
    public static function getPrevisionDateLoansByIsbn($isbn) {
    	$database = new DatabasePdo();
    	
    	$query = "select date_add(dataprestito,interval duratamax day) as date from prestiti p inner join volumi v on p.volume = v.id inner join libri l on v.libro = l.isbn where isbn=:isbn and datarestituzione is null order by date_add(dataprestito,interval duratamax day)";
    	$database->query($query);
    	$database->bind(':isbn', $isbn);
    	$result = $database->single();
    	
    	return $result['date'];
    }
    
    // funzione che restituisce i libri più prestati
    public static function getBookMoreProvided() {
    	$database = new DatabasePdo();
    	 
    	$query = "SELECT l.*,count(p.id) as pres FROM prestiti p inner join volumi v on p.volume=v.id inner join libri l on l.isbn=v.libro group by l.isbn order by pres desc LIMIT 0,4";
    	$database->query($query);
    	$books = $database->resultset();
    	 
    	$results = new ArrayObject();
    	foreach ($books as $book) {
    		$editor = EditorService::getEditorById($book['editore']);
    		$language = LanguageService::getLanguageById($book['lingua']);
    		$result = new Libro($book['isbn'], $book['titolo'], $editor, $book['annopubblicazione'], $book['recensione'], $language, $book['datainserimento'],$book['copertina']);
    		$results->append($result);
    	}
    	return $results;
    }

    public static function getBookByIsbn($isbn) {
        $database = new DatabasePdo();

        $query = "SELECT * FROM libri WHERE isbn=:isbn";
        $database->query($query);
        $database->bind(':isbn', $isbn);
        $result = $database->single();

        if($result) {
        	$editor = EditorService::getEditorById($result['editore']);
        	$language = LanguageService::getLanguageById($result['lingua']);
        	$book = new Libro($result['isbn'], $result['titolo'], $editor, $result['annopubblicazione'], $result['recensione'], $language, $result['datainserimento'],$result['copertina']);
        	$book->setAutori(AuthorService::getAuthorsByISBN($isbn));
        	$book->setTags(TagService::getTagsByISBN($isbn));       	
        	return $book;
        } else return NULL;
    }

    public static function insertBook(Libro $book) {
        $database = new DatabasePdo();

        try {

            $database->beginTransaction();

            $query = "INSERT INTO libri (isbn, titolo, editore, annopubblicazione, recensione, lingua, datainserimento, copertina) VALUES (:isbn, :titolo, :editore, :annopubblicazione, :recensione, :lingua, :datainserimento, :copertina)";
            $database->query($query);
            $database->bind(':isbn', $book->getIsbn());
            $database->bind(':titolo', $book->getTitolo());
            $database->bind(':editore', $book->getEditore()->getId());
            $database->bind(':annopubblicazione', $book->getAnnoPubblicazione());
            $database->bind(':recensione', $book->getRecensione());
            $database->bind(':lingua', $book->getLingua()->getId());
            $database->bind(':datainserimento', $book->getDataInserimento());
            $database->bind(':copertina', $book->getCopertina());
            
            $database->execute();

            $autori = $book->getAutori();
            if ($autori != NULL) {
                foreach ($autori as $autore) {
                    $query = "INSERT INTO libri_autori (libro, autore) VALUES (:libro, :autore)";
                    $database->query($query);
                    $database->bind(':libro', $book->getIsbn());
                    $database->bind(':autore', $autore->getId());
                    $database->execute();
                }
            }
            
            $tags = $book->getTags();
            if ($tags != NULL) {
                foreach ($tags as $tag) {
                    $query = "INSERT INTO libri_tags (libro, tag) VALUES (:libro, :tag)";
                    $database->query($query);
                    $database->bind(':libro', $book->getIsbn());
                    $database->bind(':tag', $tag->getId());
                    $database->execute();
                }
            }

            return $database->endTransaction();
        } catch (Exception $exc) {

            echo $exc->getTraceAsString();

            $database->cancelTransaction();
        }
    }

    public static function updateBook(Libro $book) {
        $database = new DatabasePdo();

        try {

            $database->beginTransaction();

            $query = "UPDATE libri SET titolo = :titolo, editore = :editore, annopubblicazione = :annopubblicazione, recensione = :recensione, lingua = :lingua WHERE isbn = :isbn";
            $database->query($query);
            $database->bind(':isbn', $book->getIsbn());
            $database->bind(':titolo', $book->getTitolo());
            $database->bind(':editore', $book->getEditore()->getId());
            $database->bind(':annopubblicazione', $book->getAnnoPubblicazione());
            $database->bind(':recensione', $book->getRecensione());
            $database->bind(':lingua', $book->getLingua()->getId());
            
            $database->execute();

            $query = "DELETE FROM libri_autori WHERE libro = :isbn";
            $database->query($query);
            $database->bind(':isbn', $book->getIsbn());

            $database->execute();

            $query = "DELETE FROM libri_tags WHERE libro = :isbn";
            $database->query($query);
            $database->bind(':isbn', $book->getIsbn());

            $database->execute();
            
            $autori = $book->getAutori();
            if ($autori != NULL) {
                foreach ($autori as $autore) {
                    $query = "INSERT INTO libri_autori (libro, autore) VALUES (:libro, :autore)";
                    $database->query($query);
                    $database->bind(':libro', $book->getIsbn());
                    $database->bind(':autore', $autore->getId());

                    $database->execute();
                }
            }
            
            $tags = $book->getTags();
            if ($tags != NULL) {
                foreach ($tags as $tag) {
                    $query = "INSERT INTO libri_tags (libro, tag) VALUES (:libro, :tag)";
                    $database->query($query);
                    $database->bind(':libro', $book->getIsbn());
                    $database->bind(':tag', $tag->getId());

                    $database->execute();
                }
            }

            return $database->endTransaction();
        } catch (Exception $exc) {

            echo $exc->getTraceAsString();

            $database->cancelTransaction();
        }
    }

    public static function deleteBook(Libro $book) {
        $database = new DatabasePdo();

        $query = "DELETE FROM libri WHERE isbn = :isbn";
        $database->query($query);
        $database->bind(':isbn', $book->getIsbn());

        $result = $database->execute();

        return $result;
    }

}
