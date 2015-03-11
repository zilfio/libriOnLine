<?php

/**
 * Description of Libro
 *
 * @author Zilfio
 */

class Libro {
	private $isbn;
	private $titolo;
	private $editore;
	private $annoPubblicazione;
	private $recensione;
	private $lingua;
	private $dataInserimento;

	private $autori;
	private $tags;

	private $copertina;

	function __construct($isbn, $titolo, Editore $editore, $annoPubblicazione, $recensione, Lingua $lingua, $dataInserimento, $copertina) {
		$this->isbn = $isbn;
		$this->titolo = $titolo;
		$this->editore = $editore;
		$this->annoPubblicazione = $annoPubblicazione;
		$this->recensione = $recensione;
		$this->lingua = $lingua;
		$this->dataInserimento = $dataInserimento;

		$this->autori = new ArrayObject();
		$this->tags = new ArrayObject();

		$this->volumi = new ArrayObject();

		$this->copertina = $copertina;
	}

	public function getIsbn() {
		return $this->isbn;
	}

	public function getTitolo() {
		return $this->titolo;
	}

	public function getEditore() {
		return $this->editore;
	}

	public function getAnnoPubblicazione() {
		return $this->annoPubblicazione;
	}

	public function getRecensione() {
		return $this->recensione;
	}

	public function getLingua() {
		return $this->lingua;
	}

	public function getDataInserimento() {
		return $this->dataInserimento;
	}

	public function getAutori() {
		return $this->autori;
	}

	public function getTags() {
		return $this->tags;
	}
	
	public function getCopertina() {
		return $this->copertina;
	}

	public function setIsbn($isbn) {
		$this->isbn = $isbn;
	}

	public function setTitolo($titolo) {
		$this->titolo = $titolo;
	}

	public function setEditore(Editore $editore) {
		$this->editore = $editore;
	}

	public function setAnnoPubblicazione($annoPubblicazione) {
		$this->annoPubblicazione = $annoPubblicazione;
	}

	public function setRecensione($recensione) {
		$this->recensione = $recensione;
	}

	public function setLingua(Lingua $lingua) {
		$this->lingua = $lingua;
	}

	public function setDataInserimento($dataInserimento) {
		$this->dataInserimento = $dataInserimento;
	}

	public function setAutori($autori) {
		$this->autori = $autori;
	}

	public function setTags($tags) {
		$this->tags = $tags;
	}

	public function setCopertina($copertina) {
		$this->copertina = $copertina;
	}

}
