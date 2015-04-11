<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Simplex extends Model {

	//

	public function rekursiverAufruf() {
		// das Ding soll so lange laufen, bis es xWert und yWert > 0 -> alle Methoden werden so lange aufgerufen bis dies der fall ist
		// $this->berechne Simplex

	}
	public function getPivotColumn($simplexArray) {

		if ($simplexArray[0]["xWert"] * -1 > $simplexArray[0]["yWert"] * -1) {
			echo $simplexArray[0]["xWert"];

			return "xWert";
		}else{
			echo $simplexArray[0]["yWert"];
			return "yWert";
		}
	}

	public function getPivotElement($simplexArray) {
		$pivotSpalte = $this->getPivotColumn($simplexArray);
		$pivotElement = null;
		$pivotZeile = null;
		// Ergebnis/yWert
		for($i = 1; $i<count($simplexArray); $i++){
			$potentiellesPivotElement = $simplexArray[$i]["Ergebnis"]/$simplexArray[$i][$pivotSpalte]; 
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
			//Attribute Array
		return array($pivotZeile, $pivotSpalte, $pivotElement);
	}

			// bekommt array aus getPivotElement
	public function berechnePivotSpalte($attributeArray, $simplexArray) {
		// Wert/pivotElement * -1
		for($i = 0; $i<count($simplexArray); $i++){	
		$simplexArray[$i][$attributeArray[1]] = $simplexArray[$i][$attributeArray[1]]/$attributeArray[2] * -1;
		}

		
		return $simplexArray;

	}

	public function berechnePivotZeile($attributeArray, $simplexArray) {
		$simplexArray = $this->berechnePivotSpalte($attributeArray, $simplexArray); 
		//var_dump($simplexArray);
		$simplexArray[$attributeArray[0]]['xWert'] = $simplexArray[$attributeArray[0]]['xWert']/$attributeArray[2];
		$simplexArray[$attributeArray[0]]['yWert'] = $simplexArray[$attributeArray[0]]['yWert']/$attributeArray[2];
		$simplexArray[$attributeArray[0]]['Ergebnis'] = $simplexArray[$attributeArray[0]]['Ergebnis']/$attributeArray[2];
		// PivotElement ist Kehrwert aus pivotelement!
		$simplexArray[$attributeArray[0]][$attributeArray[1]] = 1/$attributeArray[2];
		dd($simplexArray);
	}

	// a - (b*c)/d 
	public function berechneUmPivotHerum($attributeArray, $simplexArray) {
		// return array($pivotZeile, $pivotSpalte, $pivotElement);
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
		$d = $attributeArray[2]; 
		foreach ($simplexArray as $row) {
			echo $row['Ergebnis'];
		}
				// b a 
				// d c 
			
			
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


