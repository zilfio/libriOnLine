<?php

session_start();

include 'include/config.php';

include_once 'services/BookService.php';
include_once 'services/AuthorService.php';
include_once 'services/TagService.php';

require_once(ROOT_SMARTY . 'Smarty.class.php');

$smarty = new Smarty;

$smarty->template_dir = 'skins/frontend/dtml/';
$smarty->compile_dir = 'include/smarty/frontend/templates_c/';
$smarty->config_dir = 'include/smarty/frontend/configs/';
$smarty->cache_dir = 'include/smarty/frontend/cache/';

$action = $_GET['pid'];
switch ($action) {
	case '1':
		if (!isset($_REQUEST['page'])) {
			$page = 0;
		} else {
			$page = $_REQUEST['page'];
		}

		switch ($page) {
			case 0: // FORM
				$smarty->assign('body', 'advanced-search.tpl');
				$smarty->assign('autori', AuthorService::getAllAuthors());
				$smarty->assign('tags', TagService::getAllTags());
				$smarty->assign('languages', LanguageService::getAllLanguages());
				break;

			case 1: // TRANSAZIONE + NOTIFICA
				$smarty->assign('body', 'book-catalogue.tpl');
				$smarty->assign('pageTitle', 'Risultati ricerca avanzata');			
				
				$books = BookService::getAllBooksAdvancedSearch();
				$smarty->assign('books', $books);
				$smarty->assign('caption', 1);
				break;
		}
		break;

	case '2': // ricerca dei libri di un particolare autore
		$author = AuthorService::getAuthorById($_GET['author']);
		$books = BookService::getAllBooksByAuthor($author);
		
		$smarty->assign('body', 'book-catalogue.tpl');
		$smarty->assign('pageTitle', 'Risultati ricerca autore: '.$author->getNomeCognome());
		$smarty->assign('books', $books);
		$smarty->assign('caption', 1);
		break;
		
	case '3': // ricerca dei libri con un particolare tag
		$tag = TagService::getTagById($_GET['tag']);
		$books = BookService::getAllBooksByTag($tag);
		
		$smarty->assign('body', 'book-catalogue.tpl');
		$smarty->assign('pageTitle', 'Risultati ricerca tag: '.$tag->getNome());
		$smarty->assign('books', $books);
		$smarty->assign('caption', 1);
		break;
		
	default:
		$smarty->assign('body', 'book-catalogue.tpl');
		$smarty->assign('pageTitle', 'Risultati ricerca');

		$title = $_GET['title'];
		if (isset($title) && strlen($title) > 0) {
			$books = BookService::getAllBooksLikeTitle($title);
			$smarty->assign('books',$books);
			$smarty->assign('caption', 1);
		} else {
			$books = BookService::getAllBooks();
			$smarty->assign('books',$books);
			$smarty->assign('caption', 1);
		}
		break;
}

include_once 'include/logged.inc.php';

$smarty->display('page.tpl');

?>