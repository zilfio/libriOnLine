<?php

include_once 'include/DatabasePDO.php';
require 'model/Utente.php';

/**
 * Description of UsersService
 *
 * @author Zilfio
 */
class UserService {

    /**
     * 
     * @return \ArrayObject
     */
    public static function getAllUsers() {
        $database = new DatabasePdo();

        $query = "SELECT * FROM utenti";
        $database->query($query);
        $users = $database->resultset();

        $results = new ArrayObject();
        foreach ($users as $user) {
            $result = new Utente($user['id'], $user['username'], $user['password'], $user['email'], $user['telefono'], $user['nome'], $user['cognome'], $user['codicefiscale'], $user['indirizzo'], $user['citta'], $user['provincia'], $user['cap'], $user['dataregistrazione']);
            $results->append($result);
        }
        return $results;
    }
    
    public static function getNumberOfUsers() {
    	$database = new DatabasePdo();
    
    	$query = "SELECT * FROM utenti";
    	$database->query($query);
    
    	$rows = $database->resultset();
    	$result = $database->rowCount();
    
    	return $result;
    }

    /**
     * 
     * @param type $id
     * @return \Utente
     */
    public static function getUserById($id) {
        $database = new DatabasePdo();

        $query = "SELECT * FROM utenti WHERE id=:id";
        $database->query($query);
        $database->bind(':id', $id);
        $result = $database->single();

        if($result) {
        	$user = new Utente($result['id'], $result['username'], $result['password'], $result['email'], $result['telefono'], $result['nome'], $result['cognome'], $result['codicefiscale'], $result['indirizzo'], $result['citta'], $result['provincia'], $result['cap'], $result['dataregistrazione']);
        	$user->setGruppi(GroupService::getGroupsByUserId($id));
        	return $user;
        } else return NULL;
        
    }

    public static function getUserByUsername($username) {
        $database = new DatabasePdo();

        $query = "SELECT * FROM utenti WHERE username = :username";
        $database->query($query);
        $database->bind(':username', $username);
        $result = $database->single();

        $user = new Utente($result['id'], $result['username'], $result['password'], $result['email'], $result['telefono'], $result['nome'], $result['cognome'], $result['codicefiscale'], $result['indirizzo'], $result['citta'], $result['provincia'], $result['cap'], $result['dataregistrazione']);

        return $user;
    }

    /**
     * Funzione che verifica se esiste un utente nel db
     * @param type $username username dell'utente
     * @param type $password password dell'utente
     * @return type 
     */
    public static function getUserByUsernameAndPassword($username, $password) {
        if (UserService::numRowsUser($username, $password) == 1) {
            $database = new DatabasePdo();

            $query = "SELECT * FROM utenti WHERE username = :username AND password = :password";
            $database->query($query);
            $database->bind(':username', $username);
            $database->bind(':password', md5(md5($password)));

            $user = $database->single();

            return $user;
        } else {
            return NULL;
        }
    }

    /**
     * Restituisce il numero di righe nel dd di un determinato utente
     * @param type $username username dell'utente
     * @param type $password password dell'utente
     * @return type intero che indica il numero delle righe
     */
    private static function numRowsUser($username, $password) {
        $database = new DatabasePdo();

        $query = "SELECT * FROM utenti WHERE username = :username AND password = :password";
        $database->query($query);
        $database->bind(':username', $username);
        $database->bind(':password', md5(md5($password)));

        $rows = $database->resultset();
        $result = $database->rowCount();

        return $result;
    }

    function verifyExistUsername($username) {
        $database = new DatabasePdo();

        $query = "SELECT * FROM utenti WHERE username = :username";
        $database->query($query);
        $database->bind(':username', $username);
        $result = $database->single();

        if ($result != FALSE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param type $user
     * @return type
     */
    public static function insertUser(Utente $user) {
        $database = new DatabasePdo();

        try {

            $database->beginTransaction();

            $query = "INSERT INTO utenti (id, username, password, email, telefono, nome, cognome, codicefiscale, indirizzo, citta, provincia, cap, dataregistrazione) VALUES (:id, :username, :password, :email, :telefono, :nome, :cognome, :codicefiscale, :indirizzo, :citta, :provincia, :cap, :dataregistrazione)";
            $database->query($query);
            $database->bind(':id', $user->getId());
            $database->bind(':username', $user->getUsername());
            $database->bind(':password', $user->getMd5Password());
            $database->bind(':email', $user->getEmail());
            $database->bind(':telefono', $user->getTelefono());
            $database->bind(':nome', $user->getNome());
            $database->bind(':cognome', $user->getCognome());
            $database->bind(':codicefiscale', $user->getCodiceFiscale());
            $database->bind(':indirizzo', $user->getIndirizzo());
            $database->bind(':citta', $user->getCitta());
            $database->bind(':provincia', $user->getProvincia());
            $database->bind(':cap', $user->getCap());
            $database->bind(':dataregistrazione', $user->getDataRegistrazione());

            $database->execute();
            $userId = $database->lastInsertId();

            $gruppi = $user->getGruppi();
            if ($gruppi != NULL) {
                foreach ($gruppi as $gruppo) {
                    $query = "INSERT INTO utenti_gruppi (id_utente, id_gruppo) VALUES (:id_utente, :id_gruppo)";
                    $database->query($query);
                    $database->bind(':id_utente', $userId);
                    $database->bind(':id_gruppo', $gruppo->getId());
                    $database->execute();
                }
            }

            return $database->endTransaction();
        } catch (Exception $exc) {

            echo $exc->getTraceAsString();

            $database->cancelTransaction();
        }
    }

    public static function updateUser(Utente $user) {
        $database = new DatabasePdo();

        try {

            $database->beginTransaction();

            $query = "UPDATE utenti SET email = :email, telefono = :telefono, nome = :nome, cognome = :cognome, codicefiscale = :codicefiscale, indirizzo = :indirizzo, citta = :citta, provincia = :provincia, cap = :cap  WHERE id = :id";
            $database->query($query);
            $database->bind(':id', $user->getId());
            $database->bind(':email', $user->getEmail());
            $database->bind(':telefono', $user->getTelefono());
            $database->bind(':nome', $user->getNome());
            $database->bind(':cognome', $user->getCognome());
            $database->bind(':codicefiscale', $user->getCodiceFiscale());
            $database->bind(':indirizzo', $user->getIndirizzo());
            $database->bind(':citta', $user->getCitta());
            $database->bind(':provincia', $user->getProvincia());
            $database->bind(':cap', $user->getCap());

            $database->execute();

            $query = "DELETE FROM utenti_gruppi WHERE id_utente = :id";
            $database->query($query);
            $database->bind(':id', $user->getId());

            $database->execute();

            $gruppi = $user->getGruppi();
            if ($gruppi != NULL) {
                foreach ($gruppi as $gruppo) {
                    $query = "INSERT INTO utenti_gruppi (id_utente, id_gruppo) VALUES (:id_utente, :id_gruppo)";
                    $database->query($query);
                    $database->bind(':id_utente', $user->getId());
                    $database->bind(':id_gruppo', $gruppo->getId());

                    $database->execute();
                }
            }

            return $database->endTransaction();
        } catch (Exception $exc) {

            echo $exc->getTraceAsString();

            $database->cancelTransaction();
        }
    }

    public static function updateUserProfile(Utente $user) {
    	$database = new DatabasePdo();
    
    	try {
    
    		$database->beginTransaction();
    
    		$query = "UPDATE utenti SET email = :email, telefono = :telefono, nome = :nome, cognome = :cognome, codicefiscale = :codicefiscale, indirizzo = :indirizzo, citta = :citta, provincia = :provincia, cap = :cap  WHERE id = :id";
    		$database->query($query);
    		$database->bind(':id', $user->getId());
    		$database->bind(':email', $user->getEmail());
    		$database->bind(':telefono', $user->getTelefono());
    		$database->bind(':nome', $user->getNome());
    		$database->bind(':cognome', $user->getCognome());
    		$database->bind(':codicefiscale', $user->getCodiceFiscale());
    		$database->bind(':indirizzo', $user->getIndirizzo());
    		$database->bind(':citta', $user->getCitta());
    		$database->bind(':provincia', $user->getProvincia());
    		$database->bind(':cap', $user->getCap());
    
    		$database->execute();
    
    		return $database->endTransaction();
    	} catch (Exception $exc) {
    
    		echo $exc->getTraceAsString();
    
    		$database->cancelTransaction();
    	}
    }
    
    /**
     * 
     * @param type $user
     * @return type
     */
    public static function insertUserGroup($id_utente, $id_gruppo) {
        $database = new DatabasePdo();

        $query = "INSERT INTO utenti_gruppi (id_utente, id_gruppo) VALUES (:id_utente, :id_gruppo)";
        $database->query($query);
        $database->bind(':id_utente', $id_utente);
        $database->bind(':id_gruppo', $id_gruppo);

        $database->execute();
        $result = $database->lastInsertId();

        return $result;
    }

    public static function deleteUser(Utente $user) {
        $database = new DatabasePdo();

        $query = "DELETE FROM utenti WHERE id = :id";
        $database->query($query);
        $database->bind(':id', $user->getId());

        $result = $database->execute();

        return $result;
    }

    public static function updatePassword($id, $password) {
        $database = new DatabasePdo();

        $query = "UPDATE utenti SET password = :password WHERE id = :id";
        $database->query($query);
        $database->bind(':id', $id);
        $database->bind(':password', md5(md5($password)));

        $result = $database->execute();

        return $result;
    }

}
