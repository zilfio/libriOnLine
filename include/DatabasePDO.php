<?php

/**
 * Description of DatabasePdo
 *
 * 
 * Guide reference http://culttt.com/2012/10/01/roll-your-own-pdo-php-class/
 * 
 * esempio di insert
 *      
 *       $database= new DatabasePdo();
 *       $database->query('INSERT INTO mytable (FName, LName, Age, Gender) VALUES (:fname, :lname, :age, :gender)');
 *       
 *       $database->bind(':fname', 'John');
 *       $database->bind(':lname', 'Smith');
 *       $database->bind(':age', '24');
 *       $database->bind(':gender', 'male'); 
 *       $database->bind(':lname', 'Smith');
 * 
 *       $database->execute();
 * 
 */
class DatabasePDO {
    private $host      = "localhost";
    private $user      = "root";
    private $pass      = "";
    private $dbname    = "librionline";
 
    private $stmt;
    private $dbh;
    private $error;
 
    public function __construct(){
        // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        // Set options
        $options = array(
            PDO::ATTR_PERSISTENT    => true,
            PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
        );
        // Create a new PDO instanace
        try{
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        }
        // Catch any errors
        catch(PDOException $e){
            $this->error = $e->getMessage();
        }
    }

    /**
     *  
     * @param type $query rappresenta la query sql con i prepared statement
     * 
     * e.g. 
     * $database->query('INSERT INTO mytable (FName, LName, Age, Gender) VALUES (:fname, :lname, :age, :gender)'); 
     */
    public function query($query) {
        $this->stmt = $this->dbh->prepare($query);
    }

    /**
     *  La funzione bind unisce il parametro al placeholder utilizzato nella query
     * @param type $param è il nome del placeholder da andare a sostituire 
     * @param type $value è il valore da inserire al posto del placeholder
     * @param type $type è il datatype del parametro
     * 
     * e.g. 
     * 
     *       $database->bind(':fname', 'John');
     *       $database->bind(':lname', 'Smith');
     *       $database->bind(':age', '24');
     *       $database->bind(':gender', 'male'); 
     *       $database->bind(':lname', 'Smith');
     * 
     *       $database->execute();
     */
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    /**
     *  Esegue la query
     * @return type
     */
    public function execute() {
            return $this->stmt->execute();
    }

    /**
     * Restituisce le righe
     * @return type
     */
    public function resultset() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Fetching all values of a single column from a result set
     * @return type
     */
    public function resultset2() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Restituisce una singola riga
     * @return type
     */
    public function single() {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Ritorna il numero di righe modificate dalla query eseguita
     * @return type
     */
    public function rowCount() {
        return $this->stmt->rowCount();
    }

    /**
     * funzione che permette di controllare se l'inserimento è avvenuto con successo
     * @return type
     */
    public function lastInsertId() {
        return $this->dbh->lastInsertId();
    }

    /**
     * inizia una transazione sul db
     * @return type
     */
    public function beginTransaction() {
        return $this->dbh->beginTransaction();
    }

    /**
     * determina la fine della transazione eseguendo il commit
     * 
     * @return type
     */
    public function endTransaction() {
        return $this->dbh->commit();
    }

    /**
     * Annulla la transazione
     * @return type
     */
    public function cancelTransaction() {
        return $this->dbh->rollBack();
    }

    /**
     * 
     * @return type
     */
    public function debugDumpParams() {
        return $this->stmt->debugDumpParams();
    }

}
