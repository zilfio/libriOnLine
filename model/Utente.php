<?php

/**
 * Description of Utente
 *
 * @author Zilfio
 */
class Utente {

    private $id;
    private $username;
    private $md5Password;
    private $email;
    private $telefono;
    private $nome;
    private $cognome;
    private $codiceFiscale;
    private $indirizzo;
    private $citta;
    private $provincia;
    private $cap;
    private $dataRegistrazione;
    private $gruppi;

    function __construct($id, $username, $md5Password, $email, $telefono, $nome, $cognome, $codiceFiscale, $indirizzo, $citta, $provincia, $cap, $dataRegistrazione) {
        $this->id = $id;
        $this->username = $username;
        $this->md5Password = $md5Password;
        $this->email = $email;
        $this->telefono = $telefono;
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->codiceFiscale = $codiceFiscale;
        $this->indirizzo = $indirizzo;
        $this->citta = $citta;
        $this->provincia = $provincia;
        $this->cap = $cap;
        $this->dataRegistrazione = $dataRegistrazione;

        $this->gruppi = new ArrayObject();
    }

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getMd5Password() {
        return $this->md5Password;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getCognome() {
        return $this->cognome;
    }

    public function getCodiceFiscale() {
        return $this->codiceFiscale;
    }

    public function getIndirizzo() {
        return $this->indirizzo;
    }

    public function getCitta() {
        return $this->citta;
    }

    public function getProvincia() {
        return $this->provincia;
    }

    public function getCap() {
        return $this->cap;
    }

    public function getDataRegistrazione() {
        return $this->dataRegistrazione;
    }

    public function getGruppi() {
        return $this->gruppi;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setMd5Password($md5Password) {
        $this->md5Password = $md5Password;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setCognome($cognome) {
        $this->cognome = $cognome;
    }

    public function setCodiceFiscale($codiceFiscale) {
        $this->codiceFiscale = $codiceFiscale;
    }

    public function setIndirizzo($indirizzo) {
        $this->indirizzo = $indirizzo;
    }

    public function setCitta($citta) {
        $this->citta = $citta;
    }

    public function setProvincia($provincia) {
        $this->provincia = $provincia;
    }

    public function setCap($cap) {
        $this->cap = $cap;
    }

    public function setDataRegistrazione($dataRegistrazione) {
        $this->dataRegistrazione = $dataRegistrazione;
    }

    public function setGruppi($gruppi) {
        $this->gruppi = $gruppi;
    }

}
