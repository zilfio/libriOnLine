<?php

/**
 * Description of Servizio
 *
 * @author Zilfio
 */
class Servizio {
    private $id;
    private $nome;
    private $descrizione;
    private $script;
    
    function __construct($id, $nome, $descrizione, $script) {
        $this->id = $id;
        $this->nome = $nome;
        $this->descrizione = $descrizione;
        $this->script = $script;
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

    public function getScript() {
        return $this->script;
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

    public function setScript($script) {
        $this->script = $script;
    }

}
