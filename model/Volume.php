<?php

/**
 * Description of Volume
 *
 * @author Zilfio
 */
class Volume {
    private $id;
    private $condizione;
    private $libro;
    
    function __construct($id, Condizione $condizione, Libro $libro) {
        $this->id = $id;
        $this->condizione = $condizione;
        $this->libro = $libro;
    }

    public function getId() {
        return $this->id;
    }

    public function getCondizione() {
        return $this->condizione;
    }

    public function getLibro() {
        return $this->libro;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setCondizione(Condizione $condizione) {
        $this->condizione = $condizione;
    }

    public function setLibro(Libro $libro) {
        $this->libro = $libro;
    }

}
