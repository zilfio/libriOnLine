<?php

/**
 * Description of Tag
 *
 * @author Zilfio
 */
class Tag {
    private $id;
    private $nome;
    
    function __construct($id, $nome) {
        $this->id = $id;
        $this->nome = $nome;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

}
