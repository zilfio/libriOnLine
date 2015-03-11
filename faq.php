<?php

session_start();

include 'include/config.php';

require_once(ROOT_SMARTY . 'Smarty.class.php');

$smarty = new Smarty;

$smarty->template_dir = 'skins/frontend/dtml/';
$smarty->compile_dir = 'include/smarty/frontend/templates_c/';
$smarty->config_dir = 'include/smarty/frontend/configs/';
$smarty->cache_dir = 'include/smarty/frontend/cache/';

$smarty->assign('body', 'faq.tpl');

include_once 'include/logged.inc.php';

$smarty->display('page.tpl');

?>