<?php

session_start();

require "include/config.php";
require "include/auth.inc.php";

include 'services/TagService.php';
include 'services/AuthorService.php';
include 'services/BookService.php';
include 'services/ElectronicCopyService.php';
include 'services/UtilsService.php';

require_once(ROOT_SMARTY . 'Smarty.class.php');

$smarty = new Smarty;

$smarty->template_dir = 'skins/backend/dtml/';
$smarty->compile_dir = 'include/smarty/backend/templates_c/';
$smarty->config_dir = 'include/smarty/backend/configs/';
$smarty->cache_dir = 'include/smarty/backend/cache/';

include_once 'include/admin.inc.php';

$isbn = $_GET['isbn'];
$action = $_GET['pid'];
$errori = array();

switch ($action) {
	case '1': // ADD ELECTRONIC COPY
		$ris = "electronic_copy";
		if (!isset($_REQUEST['page'])) {
			$page = 0;
		} else {
			$page = $_REQUEST['page'];
		}

		switch ($page) {
			case 0: // FORM UPLOAD FILE
				$smarty->assign('body', 'electronic-copies-add.tpl');
				if (isset($isbn)) {
					if(BookService::getBookByIsbn($isbn)) {
						$smarty->assign('book', 0);
					} else {
						$message = "Impossibile trovare il libro!";
						$smarty->assign('body', 'alert.tpl');
						$smarty->assign('error', 1);
						$smarty->assign('message', $message);
						header('Refresh: 2; URL=manager-electronic-copies.php');
					}

				} else {
					$smarty->assign('book', 1);
					$books = BookService::getAllBooks();
					$smarty->assign('books', $books);
				}
				break;

			case 1: // TRANSAZIONE + NOTIFICA
				
				$libro = $_REQUEST['libro'];
				$file = $_REQUEST['electronic_copy'];

				if (isset($isbn)) {
					//convalida input
					if($_FILES[$ris]["size"] == 0) {
						$errori = "Copia elettronica obbligatoria!";
					}
				
				} else {
					//convalida input
					$errori = UtilsService::validate($libro, 1, "Libro obbligatorio", $errori);
					if($_FILES[$ris]["size"] == 0) {
						$errori = "Copia elettronica obbligatoria!";
					}
				}

				if (count($errori) == 0) {

					if (isset($isbn)) {
						$percorso = LIBRI.$_GET['isbn'].COPIELETTRONICHE;
					} else {
						$percorso = LIBRI.$_REQUEST['libro'].COPIELETTRONICHE;
					}

					if(!file_exists($percorso)) {
						mkdir($percorso, 0700);
					}

					if (isset($_REQUEST["page"]) && isset($_FILES[$ris])) {

						$allowedExts = array("pdf");
						$temp = explode(".", $_FILES[$ris]["name"]);
						$extension = end($temp);

						if (in_array($extension, $allowedExts)) {
							if ($_FILES[$ris]["error"] > 0) {
								echo "Return Code: " . $_FILES[$ris]["error"] . "<br>";
							} else {
								$i = 1;
								$trovato = FALSE;
								while ($trovato == FALSE) {
									if ((is_file($percorso . $i . "." . $extension))) {
										$i++;
									} else {
										$file = $i;
										$trovato = TRUE;
									}
								}

								if (file_exists($percorso . $file . "." . $extension)) {
									echo $file . " already exists. ";
								} else {
									move_uploaded_file($_FILES[$ris]["tmp_name"], $percorso . $file . "." . $extension);

									//  QUERY INSERIMENTO NEL DB
									$percorsoDB = $percorso . $file . "." . $extension;

									if(isset($isbn)) {
										$libro = BookService::getBookByIsbn($isbn);
									} else {
										$libro = BookService::getBookByIsbn($_REQUEST['libro']);
									}

									$electronicCopy = new CopiaElettronica(NULL, $extension, $percorsoDB, $libro);
									$success = intval(ElectronicCopyService::insertElectronicCopy($electronicCopy));
									if ($success > 0) {
										$message = "Copia elettronica inserita correttamente!";
										$errori[] = "Stored in: " . $percorso . $file . "." . $extension;
										$smarty->assign('body', 'alert.tpl');
										$smarty->assign('success', 1);
										$smarty->assign('message', $message);
										$smarty->assign('errori', $errori);
										header('Refresh: 2; URL=manager-electronic-copies.php');
									} else {
										$message = "Generic Error!";
										$smarty->assign('body', 'alert.tpl');
										$smarty->assign('error', 1);
										$smarty->assign('message', $message);
										header('Refresh: 2; URL=manager-electronic-copies.php');
									}
								}
							}
						}
						else {
							$message = "Tipo file non supportato!";
							$smarty->assign('body', 'alert.tpl');
							$smarty->assign('error', 1);
							$smarty->assign('message', $message);
							$smarty->assign('errori', $errori);
							header('Refresh: 2; URL=manager-electronic-copies.php');
						}
					} else {
						$message = "Invalid File!";
						$smarty->assign('body', 'alert.tpl');
						$smarty->assign('warning', 1);
						$smarty->assign('message', $message);
						header('Refresh: 2; URL=manager-electronic-copies.php');
					}
				} else {
					$smarty->assign('body', 'electronic-copies-add.tpl');
					$message = "Alcuni campi sono obbligatori!";
					$smarty->assign('warning', 1);
					$smarty->assign('message', $message);
					$smarty->assign('errori', $errori);
					
					foreach ($_REQUEST as $index => $value) {
						$smarty->assign($index, $value);
					}
					
					if (isset($isbn)) {
						if(BookService::getBookByIsbn($isbn)) {
							$smarty->assign('book', 0);
						} else {
							$message = "Impossibile trovare il libro!";
							$smarty->assign('body', 'alert.tpl');
							$smarty->assign('error', 1);
							$smarty->assign('message', $message);
							header('Refresh: 2; URL=manager-electronic-copies.php');
						}
					
					} else {
						$smarty->assign('book', 1);
						$books = BookService::getAllBooks();
						$smarty->assign('books', $books);
					}
				}
		}
		break;

	case '2': // DELETE ELECTRONIC COPY
		if (!isset($_REQUEST['page'])) {
			$page = 0;
		} else {
			$page = $_REQUEST['page'];
		}

		switch ($page) {
			case 0: // FORM
				$id = $_GET['id'];
				$electronicCopy = ElectronicCopyService::getElectronicCopyById($id);
				$smarty->assign('body', 'electronic-copies-delete.tpl');
				$smarty->assign('electronicCopy', $electronicCopy);
				break;

			case 1: // TRANSAZIONE + NOTIFICA
				$id_copia = $_GET['id'];
				$copia = ElectronicCopyService::getElectronicCopyById($id_copia);

				// elimino fisicammente la copia elettronica nel filesystem
				if(file_exists($copia->getPath())){
					unlink($copia->getPath());
				}

				$result = ElectronicCopyService::deleteElectronicCopy($copia);
				if ($result) {
					$message = "La copia elettronica e' stata eliminata con successo!";
					$smarty->assign('body', 'alert.tpl');
					$smarty->assign('success', 1);
					$smarty->assign('message', $message);
					if (isset($isbn)) {
						$url = 'manager-electronic-copies.php?isbn=' . $isbn;
						header('Refresh: 2; URL=' . $url);
					} else {
						header('Refresh: 2; URL=manager-electronic-copies.php');
					}
				} else {
					$message = "La copia elettronica non e' stata eliminata!";
					$smarty->assign('body', 'alert.tpl');
					$smarty->assign('error', 1);
					$smarty->assign('message', $message);
					if (isset($isbn)) {
						$url = 'manager-electronic-copies.php?isbn=' . $isbn;
						header('Refresh: 2; URL=' . $url);
					} else {
						header('Refresh: 2; URL=manager-electronic-copies.php');
					}
				}
				break;
		}
		break;

	default:
		if (isset($isbn)) {
			$book = BookService::getBookByIsbn($isbn);
			if ($book) {
				$smarty->assign('isbn', $isbn);
				$smarty->assign('electronicCopies', ElectronicCopyService::getAllElectronicCopiesByIsbn($isbn));
				$smarty->assign('body', 'electronic-copies-report.tpl');
			} else {
				$message = "Impossibile trovare le copie elettroniche del libro!";
				$smarty->assign('body', 'alert.tpl');
				$smarty->assign('error', 1);
				$smarty->assign('message', $message);
				header('Refresh: 2; URL=manager-electronic-copies.php');
			}

		} else {
			$electronicCopies = ElectronicCopyService::getAllElectronicCopies();
			$smarty->assign('electronicCopies', $electronicCopies);
			$smarty->assign('body', 'electronic-copies-report.tpl');
		}
		break;
}

$smarty->display('backoffice.tpl');
?>