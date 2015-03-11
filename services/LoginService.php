<?php

include_once 'include/DatabasePDO.php';

/**
 * Description of LoginService
 *
 * @author Zilfio
 */
class LoginService {

     /**
     * Funzione che verifica se un utente è loggato nel sistema o meno
     * @return boolean ritorna TRUE se l'utente è loggato, altrimenti FALSE
     */
    public static function isLogged() {
        if (!isset($_SESSION['user'])) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * Funzione che verifica se un utente ha i permessi di accedere ad una pagina o meno
     * @return boolean ritorna TRUE se l'utente ha i permessi, altrimenti FALSE
     */
    public static function havePermission() {
        if (isset($_SESSION['services'][basename($_SERVER['SCRIPT_NAME'])])) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
}

