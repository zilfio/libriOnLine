<?php

session_start();

require "include/config.php";
require "include/auth.inc.php";

include 'include/SimpleImage.php';

include_once 'services/BookService.php';
include_once 'services/EditorService.php';
include_once 'services/LanguageService.php';
include_once 'services/AuthorService.php';
include_once 'services/TagService.php';
include_once 'services/VolumeService.php';
include_once 'services/ElectronicCopyService.php';
include_once 'services/UtilsService.php';

require_once(ROOT_SMARTY . 'Smarty.class.php');

$smarty = new Smarty;

$smarty->template_dir = 'skins/backend/dtml/';
$smarty->compile_dir = 'include/smarty/backend/templates_c/';
$smarty->config_dir = 'include/smarty/backend/configs/';
$smarty->cache_dir = 'include/smarty/backend/cache/';

include_once 'include/admin.inc.php';

$pid = $_GET['pid'];
$errori = array();

switch ($pid) {
	case '1': // ADD BOOK
		if (!isset($_REQUEST['page'])) {
			$page = 0;
		} else {
			$page = $_REQUEST['page'];
		}

		switch ($page) {
			case 0: // FORM
				$smarty->assign('body', 'books-add.tpl');
				$editors = EditorService::getAllEditors();
				$languages = LanguageService::getAllLanguages();
				$tags = TagService::getAllTags();
				$authors = AuthorService::getAllAuthors();
				$smarty->assign('editors', $editors);
				$smarty->assign('languages', $languages);
				$smarty->assign('autori', $authors);
				$smarty->assign('tags', $tags);
				break;

			case 1: // TRANSAZIONE + NOTIFICA
				$isbn = $_REQUEST['isbn'];
				$titolo = $_REQUEST['titolo'];
				$editore = $_REQUEST['editore'];
				$annoPubblicazione = $_REQUEST['annopubblicazione'];
				$recensione = $_REQUEST['recensione'];
				$lingua = $_REQUEST['lingua'];
				$autori = $_REQUEST['autori'];
				$tags = $_REQUEST['tags'];

				//convalida input
				$errori = UtilsService::validate($isbn, 1, "ISBN obbligatorio", $errori);
				$errori = UtilsService::validate($titolo, 1, "Titolo obbligatorio", $errori);

				if (count($errori) == 0) {
					// verifico che il libro non esiste
					if(BookService::getBookByIsbn($isbn) == NULL){
						$dataInserimento = date('Y-m-d H:i:s');
						$editor = EditorService::getEditorById($editore);
						$language = LanguageService::getLanguageById($lingua);

						$book = new Libro($isbn, $titolo, $editor, $annoPubblicazione, $recensione, $language, $dataInserimento, NULL);

						if ($tags != NULL) {
							$results = new ArrayObject();
							foreach ($tags as $tag) {
								$result = TagService::getTagById($tag);
								$results->append($result);
							}
							$book->setTags($results);
						}

						if ($autori != NULL) {
							$results = new ArrayObject();
							foreach ($autori as $autore) {
								$result = AuthorService::getAuthorById($autore);
								$results->append($result);
							}
							$book->setAutori($results);
						}

						// creo la cartella in cui metterò immagine di copertina e copie elettroniche
						if(!is_dir(LIBRI.$isbn)) {
							mkdir(LIBRI.$isbn, 0700);
						}
							
						// upload immagine di copertina
						if ($_FILES["electronic_copy"]["size"] > 0) {
							$image = new librionline\SimpleImage();
							$image->load($_FILES["electronic_copy"]["tmp_name"]);
							$image->adaptive_resize(COVER_WIDTH, COVER_HEIGHT);
							$path1 = LIBRI.$isbn.'/'."copertina.jpg";
							$image->save($path1);

							$book->setCopertina($path1);
						} else {
							$image = new librionline\SimpleImage();
							$image->load(LIBRI."default.jpg");
							$path1 = LIBRI.$isbn.'/'."copertina.jpg";
							$image->save($path1);

							$book->setCopertina($path1);
						}

						$success = BookService::insertBook($book);

						if ($success) {

							$message = "Il libro e' stato inserito con successo!";
							$smarty->assign('body', 'alert.tpl');
							$smarty->assign('success', 1);
							$smarty->assign('message', $message);
							header('Refresh: 2; URL=manager-books.php');
						} else {
							// il libro non è stato creato nel database
							$message = "Il libro non e' stato creato!";
							$smarty->assign('body', 'alert.tpl');
							$smarty->assign('error', 1);
							$smarty->assign('message', $message);
							header('Refresh: 2; URL=manager-books.php');
						}
					} else {
						$smarty->assign('body', 'books-add.tpl');
						$message = "Codice ISBN gi&agrave; esistente!";
						$smarty->assign('error', 1);
						$smarty->assign('message', $message);
						$smarty->assign('errori', $errori);

						foreach ($_REQUEST as $index => $value) {
							$smarty->assign($index, $value);
						}

						// riscrivo l'editore nelle option
						$selectedEditor = EditorService::getEditorById($editore);
						$array = new ArrayObject;
						$array->append($selectedEditor);
						$smarty->assign('selectedEditor', $selectedEditor);
						$smarty->assign('editors', UtilsService::filterArraysObject(EditorService::getAllEditors(), $array));

						// riscrivo la lingua nelle option
						$selectedLanguage = LanguageService::getLanguageById($lingua);
						$array = new ArrayObject;
						$array->append($selectedLanguage);
						$smarty->assign('selectedLanguage', $selectedLanguage);
						$smarty->assign('languages', UtilsService::filterArraysObject(LanguageService::getAllLanguages(), $array));

						// riscrivo gli autori selezionati nelle option
						$authors = new ArrayObject;
						$autori = $_REQUEST['autori'];
						if ($autori != NULL) {
							foreach ($autori as $autore) {
								$authors->append(AuthorService::getAuthorById($autore));
							}
							$smarty->assign('autoriSel', $authors);
						}
						$allAuthors = AuthorService::getAllAuthors();
						$result = UtilsService::filterArraysObject($allAuthors, $authors);
						$smarty->assign('autori', $result);

						// riscrivo i tags selezionati nelle option
						$tags = new ArrayObject;
						$elementi = $_REQUEST['tags'];
						if ($elementi != NULL) {
							foreach ($elementi as $elemento) {
								$tags->append(TagService::getTagById($elemento));
							}
							$smarty->assign('tagsSel', $tags);
						}
						$allTags = TagService::getAllTags();
						$result = UtilsService::filterArraysObject($allTags, $tags);
						$smarty->assign('tags', $result);
					}
				} else {
					$smarty->assign('body', 'books-add.tpl');
					$message = "Alcuni campi sono obbligatori!";
					$smarty->assign('warning', 1);
					$smarty->assign('message', $message);
					$smarty->assign('errori', $errori);

					foreach ($_REQUEST as $index => $value) {
						$smarty->assign($index, $value);
					}

					// riscrivo l'editore nelle option
					$selectedEditor = EditorService::getEditorById($editore);
					$array = new ArrayObject;
					$array->append($selectedEditor);
					$smarty->assign('selectedEditor', $selectedEditor);
					$smarty->assign('editors', UtilsService::filterArraysObject(EditorService::getAllEditors(), $array));

					// riscrivo la lingua nelle option
					$selectedLanguage = LanguageService::getLanguageById($lingua);
					$array = new ArrayObject;
					$array->append($selectedLanguage);
					$smarty->assign('selectedLanguage', $selectedLanguage);
					$smarty->assign('languages', UtilsService::filterArraysObject(LanguageService::getAllLanguages(), $array));

					// riscrivo gli autori selezionati nelle option
					$authors = new ArrayObject;
					$autori = $_REQUEST['autori'];
					if ($autori != NULL) {
						foreach ($autori as $autore) {
							$authors->append(AuthorService::getAuthorById($autore));
						}
						$smarty->assign('autoriSel', $authors);
					}
					$allAuthors = AuthorService::getAllAuthors();
					$result = UtilsService::filterArraysObject($allAuthors, $authors);
					$smarty->assign('autori', $result);

					// riscrivo i tags selezionati nelle option
					$tags = new ArrayObject;
					$elementi = $_REQUEST['tags'];
					if ($elementi != NULL) {
						foreach ($elementi as $elemento) {
							$tags->append(TagService::getTagById($elemento));
						}
						$smarty->assign('tagsSel', $tags);
					}
					$allTags = TagService::getAllTags();
					$result = UtilsService::filterArraysObject($allTags, $tags);
					$smarty->assign('tags', $result);
				}
				break;
		}

		break;

	case '2': // BOOK UPDATE
		if (!isset($_REQUEST['page'])) {
			$page = 0;
		} else {
			$page = $_REQUEST['page'];
		}

		switch ($page) {
			case 0: // FORM
				$isbn = $_GET['isbn'];
				$book = BookService::getBookByIsbn($isbn);

				if ($book) {
					$smarty->assign('body', 'books-update.tpl');

					$smarty->assign('isbn', $book->getIsbn());
					$smarty->assign('titolo', $book->getTitolo());
					$smarty->assign('annopubblicazione', $book->getAnnoPubblicazione());
					$smarty->assign('recensione', $book->getRecensione());

					$authors = AuthorService::getAllAuthors();
					$authorsNotSel = UtilsService::filterArraysObject($authors, $book->getAutori());

					$editor = $book->getEditore();
					$array = new ArrayObject;
					$array->append($editor);
					$smarty->assign('selectedEditor', $editor);
					$smarty->assign('editors', UtilsService::filterArraysObject(EditorService::getAllEditors(), $array));


					$language = $book->getLingua();
					$array = new ArrayObject;
					$array->append($language);
					$smarty->assign('selectedLanguage', $language);
					$smarty->assign('languages', UtilsService::filterArraysObject(LanguageService::getAllLanguages(), $array));

					$tags = TagService::getAllTags();
					$tagsNotSel = UtilsService::filterArraysObject($tags, $book->getTags());

					$smarty->assign('autoriSel', $book->getAutori());
					$smarty->assign('autori', $authorsNotSel);

					$smarty->assign('tagsSel', $book->getTags());
					$smarty->assign('tags', $tagsNotSel);

					$smarty->assign('copertina', $book->getCopertina());
				} else {
					$message = "Impossibile trovare il libro!";
					$smarty->assign('body', 'alert.tpl');
					$smarty->assign('error', 1);
					$smarty->assign('message', $message);
					header('Refresh: 2; URL=manager-books.php');
				}
				break;

			case 1: // TRANSAZIONE + NOTIFICA (dati del libro)
				$isbn = $_REQUEST['isbn'];
				$titolo = $_REQUEST['titolo'];
				$editore = $_REQUEST['editore'];
				$annoPubblicazione = $_REQUEST['annopubblicazione'];
				$recensione = $_REQUEST['recensione'];
				$lingua = $_REQUEST['lingua'];
				$autori = $_REQUEST['autori'];
				$tags = $_REQUEST['tags'];

				//convalida input
				$errori = UtilsService::validate($isbn, 1, "ISBN obbligatorio", $errori);
				$errori = UtilsService::validate($titolo, 1, "Titolo obbligatorio", $errori);

				if (count($errori) == 0) {
					$old_book = BookService::getBookByIsbn($isbn);

					$editor = EditorService::getEditorById($editore);
					$language = LanguageService::getLanguageById($lingua);

					$book = new Libro($isbn, $titolo, $editor, $annoPubblicazione, $recensione, $language, $old_book->getDataInserimento(),NULL);
					if ($tags != NULL) {
						$results = new ArrayObject();
						foreach ($tags as $tag) {
							$result = TagService::getTagById($tag);
							$results->append($result);
						}
						$book->setTags($results);
					}

					if ($autori != NULL) {
						$results = new ArrayObject();
						foreach ($autori as $autore) {
							$result = AuthorService::getAuthorById($autore);
							$results->append($result);
						}
						$book->setAutori($results);
					}

					$success = BookService::updateBook($book);

					if ($success) {
						$message = "Il libro e' stato modificato con successo!";
						$smarty->assign('body', 'alert.tpl');
						$smarty->assign('success', 1);
						$smarty->assign('message', $message);
						header('Refresh: 2; URL=manager-books.php');
					} else {
						$message = "Il libro non e' stato modificato!";
						$smarty->assign('body', 'alert.tpl');
						$smarty->assign('error', 1);
						$smarty->assign('message', $message);
						header('Refresh: 2; URL=manager-books.php');
					}
				} else {
					$smarty->assign('body', 'books-update.tpl');
					$message = "Alcuni campi sono obbligatori!";
					$smarty->assign('warning', 1);
					$smarty->assign('message', $message);
					$smarty->assign('errori', $errori);

					foreach ($_REQUEST as $index => $value) {
						$smarty->assign($index, $value);
					}

					// riscrivo l'editore nelle option
					$selectedEditor = EditorService::getEditorById($editore);
					$array = new ArrayObject;
					$array->append($selectedEditor);
					$smarty->assign('selectedEditor', $selectedEditor);
					$smarty->assign('editors', UtilsService::filterArraysObject(EditorService::getAllEditors(), $array));

					// riscrivo la lingua nelle option
					$selectedLanguage = LanguageService::getLanguageById($lingua);
					$array = new ArrayObject;
					$array->append($selectedLanguage);
					$smarty->assign('selectedLanguage', $selectedLanguage);
					$smarty->assign('languages', UtilsService::filterArraysObject(LanguageService::getAllLanguages(), $array));

					// riscrivo gli autori selezionati nelle option
					$authors = new ArrayObject;
					$autori = $_REQUEST['autori'];
					if ($autori != NULL) {
						foreach ($autori as $autore) {
							$authors->append(AuthorService::getAuthorById($autore));
						}
						$smarty->assign('autoriSel', $authors);
					}
					$allAuthors = AuthorService::getAllAuthors();
					$result = UtilsService::filterArraysObject($allAuthors, $authors);
					$smarty->assign('autori', $result);

					// riscrivo i tags selezionati nelle option
					$tags = new ArrayObject;
					$elementi = $_REQUEST['tags'];
					if ($elementi != NULL) {
						foreach ($elementi as $elemento) {
							$tags->append(TagService::getTagById($elemento));
						}
						$smarty->assign('tagsSel', $tags);
					}
					$allTags = TagService::getAllTags();
					$result = UtilsService::filterArraysObject($allTags, $tags);
					$smarty->assign('tags', $result);
				}
				break;

			case 2: // TRANSAZIONE + NOTIFICA (cover libro)
				// upload immagine di copertina
				$isbn = $_GET['isbn'];
				if($_FILES["electronic_copy"]["size"] > 0) {
					$image = new librionline\SimpleImage();
					$image->load($_FILES["electronic_copy"]["tmp_name"]);
					$image->adaptive_resize(COVER_WIDTH, COVER_HEIGHT);
					$path1 = LIBRI.$isbn."/"."copertina.jpg";
					$image->save($path1);
						
					$message = "L'immagine di copertina &egrave; stata modificata correttamente!";
					$smarty->assign('body', 'alert.tpl');
					$smarty->assign('success', 1);
					$smarty->assign('message', $message);
					header('Refresh: 2; URL=manager-books.php');
				} else {
					$smarty->assign('body', 'books-update.tpl');
					$message = "Immagine di copertina vuota!";
					$smarty->assign('warning', 1);
					$smarty->assign('message', $message);
					$smarty->assign('errori', $errori);
						
					$book = BookService::getBookByIsbn($isbn);
					
					if ($book) {
							
						$smarty->assign('isbn', $book->getIsbn());
						$smarty->assign('titolo', $book->getTitolo());
						$smarty->assign('annopubblicazione', $book->getAnnoPubblicazione());
						$smarty->assign('recensione', $book->getRecensione());
							
						$authors = AuthorService::getAllAuthors();
						$authorsNotSel = UtilsService::filterArraysObject($authors, $book->getAutori());
							
						$editor = $book->getEditore();
						$array = new ArrayObject;
						$array->append($editor);
						$smarty->assign('selectedEditor', $editor);
						$smarty->assign('editors', UtilsService::filterArraysObject(EditorService::getAllEditors(), $array));
							
							
						$language = $book->getLingua();
						$array = new ArrayObject;
						$array->append($language);
						$smarty->assign('selectedLanguage', $language);
						$smarty->assign('languages', UtilsService::filterArraysObject(LanguageService::getAllLanguages(), $array));
							
						$tags = TagService::getAllTags();
						$tagsNotSel = UtilsService::filterArraysObject($tags, $book->getTags());
							
						$smarty->assign('autoriSel', $book->getAutori());
						$smarty->assign('autori', $authorsNotSel);
							
						$smarty->assign('tagsSel', $book->getTags());
						$smarty->assign('tags', $tagsNotSel);
							
						$smarty->assign('copertina', $book->getCopertina());
					}
				}
				break;
		}
		break;

	case '3': // BOOK DELETE

		$isbn = $_GET['isbn'];

		if (!isset($_REQUEST['page'])) {
			$page = 0;
		} else {
			$page = $_REQUEST['page'];
		}

		switch ($page) {
			case 0: // FORM
				$book = BookService::getBookByIsbn($isbn);
				if ($book) {
					$smarty->assign('body', 'books-delete.tpl');
					$smarty->assign('book', $book);
				} else {
					$message = "Impossibile trovare il libro!";
					$smarty->assign('body', 'alert.tpl');
					$smarty->assign('error', 1);
					$smarty->assign('message', $message);
					header('Refresh: 2; URL=manager-books.php');
				}
				break;

			case 1: // TRANSAZIONE + NOTIFICA

				$book = BookService::getBookByIsbn($isbn);

				$result = BookService::deleteBook($book);
				if ($result) {

					// elimino la cartella in cui sono contenuti tutte le copie elettroniche e la copertina del libro
					if(is_dir(LIBRI.$isbn)) {
						UtilsService::rrmdir(LIBRI.$isbn);
					}

					$message = "Il libro e' stato eliminato con successo!";
					$smarty->assign('body', 'alert.tpl');
					$smarty->assign('success', 1);
					$smarty->assign('message', $message);
					header('Refresh: 2; URL=manager-books.php');
				} else {
					$message = "Il libro non e' stato eliminato!";
					$smarty->assign('body', 'alert.tpl');
					$smarty->assign('success', 1);
					$smarty->assign('message', $message);
					header('Refresh: 2; URL=manager-books.php');
				}
				break;
		}
		break;

	case '4': // BOOK DETAIL
		$isbn = $_GET['isbn'];
		$book = BookService::getBookByIsbn($isbn);
		if ($book) {
			$smarty->assign('body', 'books-details.tpl');
			$smarty->assign('book', $book);
			$smarty->assign('volumiTot', VolumeService::getTotalNumberVolumesByIsbn($isbn));
			$smarty->assign('volumiDisp', VolumeService::getTotalNumberVolumesByIsbn($isbn) - VolumeService::getTotalNumberVolumesProvidedByIsbn($isbn));

			// data presunta di riconsegna
			$smarty->assign('datePrConsegna', BookService::getPrevisionDateLoansByIsbn($isbn));

			// copie elettroniche
			$electronicCopies = ElectronicCopyService::getAllElectronicCopiesByIsbn($isbn);
			$smarty->assign('electronicCopies', $electronicCopies);

		} else {
			$message = "Impossibile trovare il libro!";
			$smarty->assign('body', 'alert.tpl');
			$smarty->assign('error', 1);
			$smarty->assign('message', $message);
			header('Refresh: 2; URL=manager-books.php');
		}

		break;

	case '5':

	default:
		$books = BookService::getAllBooks();
		$smarty->assign('books', $books);
		$smarty->assign('body', 'books-report.tpl');
		break;
}

$smarty->display('backoffice.tpl');
?>