<?php

/**
 * Description of UtilsService
 *
 * @author Zilfio
 */
class UtilsService {

	/**
	 * Elimina intera directory e file che ci sono
	 * @param stringa $dir path della directory da eliminare
	 */
	public static function rrmdir($dir) {
	 if (is_dir($dir)) {
	 	$objects = scandir($dir);
	 	foreach ($objects as $object) {
	 		if ($object != "." && $object != "..") {
	 			if (filetype($dir."/".$object) == "dir") self::rrmdir($dir."/".$object); else unlink($dir."/".$object);
	 		}
	 	}
	 	reset($objects);
	 	rmdir($dir);
	 }
	}

	/**
	 * Metodo che verifica se un oggetto è vuoto oppure no
	 * @param type $obj oggetto che si vuole verificare
	 * @return boolean TRUE se è vuoto altrimenti FALSE
	 */
	public static function isEmptyObject($obj) {
		$arr = (array)$obj;
		if (empty($arr)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Metodo che genera automaticamente una password di 8 caratteri
	 * @param type $length intero che indica la lunghezza della password da generare
	 * @return type stringa di 8 caratteri generata automaticamente
	 */
	public static function generatePassword($length = 8) {
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$count = mb_strlen($chars);

		for ($i = 0, $result = ''; $i < $length; $i++) {
			$index = rand(0, $count - 1);
			$result .= mb_substr($chars, $index, 1);
		}

		return $result;
	}

	public static function email_valida($mail) {
		if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
			return TRUE;
		}
		return FALSE;
	}

	//    public static function filterServices($arrayA, $arrayB) {
	//        if (count($arrayB) == 0) {
	//            return $arrayA;
	//        } else {
	//            $result = new ArrayObject();
	//            foreach ($arrayA as $elementA) {
	//                foreach ($arrayB as $elementB) {
	//                    if (!($elementA->getId() == $elementB->getId()) && !UtilsService::findObjectInArrayObject($arrayB, $elementA)) {
	//                        $result->append($elementA);
	//                    }
	//                }
	//            }
	//            return $result;
	//        }
	//    }


	private static function findObjectInArrayObject($array, $object) {
		foreach ($array as $element) {
			if ($element->getId() == $object->getId()) {
				return TRUE;
			}
		}
		return FALSE;
	}

	public static function filterArraysObject($arrayA, $arrayB) {
		$result = new ArrayObject();
		if (count($arrayB) == 0) {
			return $arrayA;
		} else {
			foreach ($arrayA as $elementA) {
				if (!UtilsService::findObjectInArrayObject($arrayB, $elementA)) {
					$result->append($elementA);
				}
			}
			return $result;
		}
	}

	private static function findObjectInArrayObject2($array, $object) {
		foreach ($array as $element) {
			if ($element->getIsbn() == $object->getIsbn()) {
				return TRUE;
			}
		}
		return FALSE;
	}

	public static function filterArraysObject2($arrayA, $arrayB) {
		$result = new ArrayObject();
		if (count($arrayB) == 0) {
			return $arrayA;
		} else {
			foreach ($arrayA as $elementA) {
				if (!UtilsService::findObjectInArrayObject2($arrayB, $elementA)) {
					$result->append($elementA);
				}
			}
			return $result;
		}
	}

	public static function checkCodiceFiscale($cf) {
		if (eregi("^[a-z]{6}[0-9]{2}[a-z][0-9]{2}[a-z][0-9]{3}[a-z]$", $cf)) {
			return true;
		} else {
			return false;
		}
	}

	public static function validate($value,$regExPatternIndex,$errorMessage,$errori){

		$regEx= array();
		// campo obbligatorio
		$regEx[1]="/\S/";
		// cf
		$regEx[2]="/^[A-Za-z]{6}\d{2}[A-Za-z]\d{2}[A-Za-z]\d{3}[A-Za-z]$/";
		// mail
		$regEx[3]="/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
		// phone
		$regEx[4]="/^[\+0-9\-\(\)\s]*$/";

		if (!preg_match($regEx[$regExPatternIndex], $value)){
			//non valido
			$errori[]= $errorMessage;
		}
		return $errori;
	}

}

?>