<?php

/**
 * Description of Prestito
 *
 * @author Zilfio
 */
class Prestito {
    private $id;
    private $durataMax;
    private $dataPrestito;
    private $dataPresuntaRestituzione;
    private $dataRestituzione;
    private $volume;
    private $utente;
    
    function __construct($id, $durataMax, $dataPrestito, $dataRestituzione, Volume $volume, Utente $utente) {
        $this->id = $id;
        $this->durataMax = $durataMax;
        $this->dataPrestito = $dataPrestito;
        
        $this->dataPresuntaRestituzione = Prestito::addDayswithdate($dataPrestito, $durataMax);
        
        $this->dataRestituzione = $dataRestituzione;
        
        $this->volume = $volume;
        $this->utente = $utente;
    }
    
    public static function addDayswithdate($date,$days){

        $date = strtotime("+".$days." days", strtotime($date));
        return  date("Y-m-d", $date);

    }   
    
    public function getId() {
        return $this->id;
    }

    public function getDurataMax() {
        return $this->durataMax;
    }

    public function getDataPrestito() {
        return $this->dataPrestito;
    }

    public function getDataRestituzione() {
        return $this->dataRestituzione;
    }

    public function getVolume() {
        return $this->volume;
    }

    public function getUtente() {
        return $this->utente;
    }
    
    public function getDataPresuntaRestituzione() {
        return $this->dataPresuntaRestituzione;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDurataMax($durataMax) {
        $this->durataMax = $durataMax;
    }

    public function setDataPrestito($dataPrestito) {
        $this->dataPrestito = $dataPrestito;
    }

    public function setDataRestituzione($dataRestituzione) {
        $this->dataRestituzione = $dataRestituzione;
    }

    public function setVolume(Volume $volume) {
        $this->volume = $volume;
    }

    public function setUtente(Utente $utente) {
        $this->utente = $utente;
    }
    
    public function setDataPresuntaRestituzione($dataPresuntaRestituzione) {
        $this->dataPresuntaRestituzione = $dataPresuntaRestituzione;
    }

}
