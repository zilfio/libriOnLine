<?php

/**
 * Description of Gruppo
 *
 * @author Zilfio
 */
class Gruppo {

    private $id;
    private $nome;
    private $descrizione;
    private $servizi;

    function __construct($id, $nome, $descrizione) {
        $this->id = $id;
        $this->nome = $nome;
        $this->descrizione = $descrizione;
        
        $this->servizi = new ArrayObject();
    }

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getDescrizione() {
        return $this->descrizione;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setDescrizione($descrizione) {
        $this->descrizione = $descrizione;
    }
    
    public function getServizi() {
        return $this->servizi;
    }

    public function setServizi($servizi) {
        $this->servizi = $servizi;
    }

}
