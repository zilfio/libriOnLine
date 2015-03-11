<?php

include 'services/LoginService.php';

// cambia Login->Dashboard se l'utente è loggato nel sistema
$loggato = LoginService::isLogged();
$smarty->assign('loggato',$loggato);

?>