<?php

session_start();

include 'include/config.php';

include_once 'services/BookService.php';
include_once 'services/AuthorService.php';
include_once 'services/TagService.php';
include_once 'services/VolumeService.php';
include_once 'services/ElectronicCopyService.php';

require_once(ROOT_SMARTY . 'Smarty.class.php');

$smarty = new Smarty;

$smarty->template_dir = 'skins/frontend/dtml/';
$smarty->compile_dir = 'include/smarty/frontend/templates_c/';
$smarty->config_dir = 'include/smarty/frontend/configs/';
$smarty->cache_dir = 'include/smarty/frontend/cache/';

include_once 'include/admin.inc.php';

$smarty->assign('body', 'book-detail.tpl');

$isbn = $_GET['isbn'];
$book = BookService::getBookByIsbn($isbn);
if ($book) {
	$smarty->assign('book', $book);
	
	$electronicCopies = ElectronicCopyService::getAllElectronicCopiesByIsbn($isbn);
	$smarty->assign('electronicCopies', $electronicCopies);
	
	$smarty->assign('volumiTot', VolumeService::getTotalNumberVolumesByIsbn($isbn));
	$smarty->assign('volumiDisp', VolumeService::getTotalNumberVolumesByIsbn($isbn) - VolumeService::getTotalNumberVolumesProvidedByIsbn($isbn));
	
	// data presunta di riconsegna
	$smarty->assign('datePrConsegna', BookService::getPrevisionDateLoansByIsbn($isbn));
	
	$relatedBooks = BookService::getOtherBooks($book);
	
	$smarty->assign('relatedBooks', $relatedBooks);	
	
	include_once 'include/logged.inc.php';
	
	$smarty->assign('caption', 1);
	
	$smarty->display('page.tpl');
} else {
	Header("Location: book-catalogue.php");
}



?>