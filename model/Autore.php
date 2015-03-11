<?php

/**
 * Description of Autore
 *
 * @author Zilfio
 */
class Autore {
    private $id;
    private $nome;
    private $cognome;
    
    function __construct($id, $nome, $cognome) {
        $this->id = $id;
        $this->nome = $nome;
        $this->cognome = $cognome;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getCognome() {
        return $this->cognome;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setCognome($cognome) {
        $this->cognome = $cognome;
    }
    
    public function getNomeCognome() {
    	return $this->nome . " " . $this->cognome;
    }

}
