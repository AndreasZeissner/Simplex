<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Simplex extends Model {

	//



	public function berechneSimplexTableau($simplexArray) {
		// das Ding soll so lange laufen, bis es xWert und yWert > 0 -> alle Methoden werden so lange aufgerufen bis dies der fall ist
		// $this->berechne Simplex
		// while (($simplexArray[0]['xWert'] < 0)  || ($simplexArray[0]['yWert'] < 0)) {
		// 	$simplexArray = $this->simplexTableau($simplexArray);
		// }
		do {
			$simplexArray = $this->simplexTableau($simplexArray);
				var_dump($simplexArray);
		} while (($simplexArray[0]['xWert'] < 0)  && ($simplexArray[0]['yWert'] < 0)); 
			return $simplexArray;
	}
	// Ermittelt die Pivot Column
	public function getPivotColumn($simplexArray) {
		if ($simplexArray[0]["xWert"] > $simplexArray[0]["yWert"]) {

			return "xWert";
		}else{
			echo $simplexArray[0]["yWert"];
			return "yWert";
		}
	}

	public function simplexTableau($simplexArray) {
		$pivotSpalte = $this->getPivotColumn($simplexArray);
		// dd($pivotSpalte);
		$pivotElement = null;
		$pivotZeile = null;
		$temp = $simplexArray[1]['Ergebnis']/$simplexArray[1][$pivotSpalte];
		// Ergebnis/yWert
		for($i = 1; $i<count($simplexArray); $i++) {
			echo "Pivot";
			var_dump($pivotElement);
			echo "Temp";
			var_dump($temp);
			// dd($simplexArray[$i][$pivotSpalte]); 
			if ($simplexArray[$i][$pivotSpalte] != 0) {
				if($temp >= $simplexArray[$i]['Ergebnis']/$simplexArray[$i][$pivotSpalte]) {
					$pivotElement = $simplexArray[$i][$pivotSpalte];
					$pivotZeile = $i;
				}
			}
		}




		// for($i = 1; $i<count($simplexArray); $i++){

		// 	$potentiellesPivotElement = $simplexArray[$i]["Ergebnis"]/$simplexArray[$i][$pivotSpalte]; 
		// 	// legt initialen Wert für Pivotelement fest

		// 	if ($i == 1) {
		// 		$pivotElement = $potentiellesPivotElement;
		// 	}

		// 	// ermittelt aktuelles Pivotelement aus jeder Spalte beschreibt es mit porentiellem 
		// 	// wir brauchen das kleinste positive
			
		// 		if ($potentiellesPivotElement < $pivotElement) {
		// 			$pivotElement = $simplexArray[$i][$pivotSpalte];
		// 			echo "Pivotelement";
		// 			var_dump($pivotElement);
		// 			$pivotZeile = $i;
		// 		}

			
		// }
			//Attribute Array
		$attributeArray = array($pivotZeile, $pivotSpalte, $pivotElement);
			// dd($attributeArray);
		$simplexArray = $this->berechneUmPivotHerum($attributeArray, $simplexArray);
		$simplexArray = $this->berechnePivotSpalte($attributeArray, $simplexArray);
			// dd($simplexArray); // 
		$simplexArray = $this->berechnePivotZeile($attributeArray, $simplexArray);
		return $simplexArray;
	}

			// bekommt array aus getPivotElement
	// Berechnet die Spalte
	public function berechnePivotSpalte($attributeArray, $simplexArray) {
		// Wert/pivotElement * -1
		for($i = 0; $i<count($simplexArray); $i++){	
		$simplexArray[$i][$attributeArray[1]] = $simplexArray[$i][$attributeArray[1]]/$attributeArray[2] * -1;
		}

		
		return $simplexArray;

	}
	// Berechnet die Spalte
	public function berechnePivotZeile($attributeArray, $simplexArray) {
		//$simplexArray = $this->berechnePivotSpalte($attributeArray, $simplexArray); 
	
		$simplexArray[$attributeArray[0]]['xWert'] = $simplexArray[$attributeArray[0]]['xWert']/$attributeArray[2];
		$simplexArray[$attributeArray[0]]['yWert'] = $simplexArray[$attributeArray[0]]['yWert']/$attributeArray[2];
		$simplexArray[$attributeArray[0]]['Ergebnis'] = $simplexArray[$attributeArray[0]]['Ergebnis']/$attributeArray[2];
		// PivotElement ist Kehrwert aus pivotelement!
		$simplexArray[$attributeArray[0]][$attributeArray[1]] = 1/$attributeArray[2];
		// dd($simplexArray);
			

		return $simplexArray;
	}

	// a - (b*c)/d 
	public function berechneUmPivotHerum($attributeArray, $simplexArray) {
		// return array($pivotZeile, $pivotSpalte, $pivotElement);as
		// Ausnahme: PivotZeile und PivotSpalte!
		// d ist immer das PivotElemnt 
		// c ist immer in der PivotZeile 
		// b ist immer in der PivotSpalte -> Ausschluss der Berechnung!
		// a ist flexibel, je nachdem richtet sich dann c und b 
		// if PivotSpalte == xWert {b ist immer der wert aus der Spalte die ich gerade berechne}
		// b = wert[$simplexSpalte]
		// 
		// if Pivotspalte == yWert {}
		// immer gerade die berechnen, die nicht in die Spalte fallen
		// dd($attributeArray[0]);
			for ($i = 0; $i<count($simplexArray); $i++) {
				if ($i != $attributeArray[0]) {
					if ($attributeArray[1] == "xWert") {;
						$simplexArray[$i]['Ergebnis'] = $simplexArray[$i]['Ergebnis'] - ($simplexArray[$i][$attributeArray[1]] * $simplexArray[$attributeArray[0]]['Ergebnis']) / $attributeArray[2];  
						$simplexArray[$i]['yWert'] = $simplexArray[$i]['yWert'] -($simplexArray[$i][$attributeArray[1]] * $simplexArray[$attributeArray[0]]['yWert']) / $attributeArray[2]; 
					} else {
						$simplexArray[$i]['Ergebnis'] = $simplexArray[$i]['Ergebnis'] - ($simplexArray[$i][$attributeArray[1]] * $simplexArray[$attributeArray[0]]['Ergebnis']) / $attributeArray[2];  
						$simplexArray[$i]['xWert'] = $simplexArray[$i]['xWert'] - ($simplexArray[$i][$attributeArray[1]] * $simplexArray[$attributeArray[0]]['xWert']) / $attributeArray[2]; 
					}
				}
			}
		return $simplexArray;
			
		}
		

	




}


