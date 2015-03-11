<?php

session_start();

include 'include/config.php';

include_once 'services/BookService.php';

require_once(ROOT_SMARTY . 'Smarty.class.php');

$smarty = new Smarty;

$smarty->template_dir = 'skins/frontend/dtml/';
$smarty->compile_dir = 'include/smarty/frontend/templates_c/';
$smarty->config_dir = 'include/smarty/frontend/configs/';
$smarty->cache_dir = 'include/smarty/frontend/cache/';

$smarty->assign('body', 'book-catalogue.tpl');
$smarty->assign('pageTitle', 'Catalogo libri');

$books = BookService::getAllBooks();
$smarty->assign('books',$books);

include_once 'include/logged.inc.php';

$smarty->assign('catalogue', 1);
$smarty->assign('caption', 1);

$smarty->display('page.tpl');

?>