<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Simplex extends Model {

	//
	public function getPivotColumn($array) {
		if ($array[0]["xWert"] * -1 > $array[0]["yWert"] * -1) {
			echo $array[0]["xWert"];

			return "xWert";
		}else{
			echo $array[0]["yWert"];
			return "yWert";
		}
	}

	public function getPivotElement($array) {
		$pivotSpalte = $this->getPivotColumn($array);
		$pivotElement = null;
		$pivotZeile = null;
		// Ergebnis/yWert
		for($i = 1; $i<count($array); $i++){
			$potentiellesPivotElement = $array[$i]["Ergebnis"]/$array[$i][$pivotSpalte]; 
			// legt initialen Wert für Pivotelement fest
			if ($i == 1) {
				$pivotElement = $potentiellesPivotElement;
			}
			// ermittelt aktuelles Pivotelement aus jeder Spalte beschreibt es mit porentiellem 
			// wir brauchen das kleinste positive
			if ($potentiellesPivotElement < $pivotElement) {
				$pivotElement = $potentiellesPivotElement;
				$pivotZeile = $i;
			}
		}
		return array($pivotZeile, $pivotElement);
	}
}


	// $simplexArray = 
	// 		array(
	// 			array("xWert" => -210, "yWert" => -160, "Ergebnis" => -640),			
	// 			array("xWert" => 4, "yWert" => 2, "Ergebnis" => 17),		
	// 			array("xWert" => 2, "yWert" => 1, "Ergebnis" => 4),
	// 			array("xWert" => 7, "yWert" => 5, "Ergebnis" => 35),
	// 			array("xWert" => 1, "yWert" => 0, "Ergebnis" => 3),
	// 			);


