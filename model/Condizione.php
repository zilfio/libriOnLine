<?php

/**
 * Description of Condizione
 *
 * @author Zilfio
 */
class Condizione {
    private $id;
    private $nome;
    private $descrizione;
    
    function __construct($id, $nome, $descrizione) {
        $this->id = $id;
        $this->nome = $nome;
        $this->descrizione = $descrizione;
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

}
