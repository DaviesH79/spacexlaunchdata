<?php

class Json_to_csv{

	public function execute(){
		$data = $this->readFileContents();
		$cleanData = $this->cleanData($data);
		$csv = $this->buildColumnNames($cleanData);
		// write to a csv file
	}

	public function buildColumnNames($array){
	
		$firstRowArray = [];	
		// iterate array to find all columns
		foreach($array as $key => $value){
			var_dump($value);
			if(is_array($value)){
				print_r('is an array');
				$name = array_key_first($value);
				$firstRowArray[] = $key . "." . $name;
				unset($value[$name]);
				$this->buildColumnNames($value);
			} else {
				$firstRowArray[] = $key;
			} 
		}
			$firstRow = implode(",", $firstRowArray);
			var_dump($firstRow);
	}

	public function cleanData($data){
		$jsonArray = json_decode($data, true);
		$launchData = $jsonArray['data']['launches'];
		return $launchData[0];	
	}

	public function readFileContents(){
		$data = file_get_contents('launchdata.txt');
		return $data;
	}

}

$convertData = new Json_to_csv();
$convertData->execute();
?>


