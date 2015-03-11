<?php

/**
 * Description of CopiaElettronica
 *
 * @author Zilfio
 */
class CopiaElettronica {

    private $id;
    private $mimetype;
    private $path;
    private $libro;

    function __construct($id, $mimetype, $path, Libro $libro) {
        $this->id = $id;
        $this->mimetype = $mimetype;
        $this->path = $path;

        $this->libro = $libro;
    }

    public function getId() {
        return $this->id;
    }

    public function getMimetype() {
        return $this->mimetype;
    }

    public function getPath() {
        return $this->path;
    }

    public function getLibro() {
        return $this->libro;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setMimetype($mimetype) {
        $this->mimetype = $mimetype;
    }

    public function setPath($path) {
        $this->path = $path;
    }

    public function setLibro(Libro $libro) {
        $this->libro = $libro;
    }


}
