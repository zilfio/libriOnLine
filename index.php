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

$smarty->assign('body', 'index.tpl');

$lastBooks = BookService::getLastBooks();
$smarty->assign('lastBooks',$lastBooks);

$moreProvided = BookService::getBookMoreProvided();
$smarty->assign('moreProvided',$moreProvided);

include_once 'include/logged.inc.php';

$smarty->display('layout.tpl');

?>