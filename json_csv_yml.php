<?php

class Json_to_csv{

	public $firstRowArray= [];

	public function execute(){
		$data = $this->readFileContents();
		$cleanData = $this->cleanData($data);
		$csv = $this->buildColumnNames($cleanData);
		// write to a csv file
	}

	public function buildColumnNames($array){
	
		// iterate array to find all columns
		foreach($array as $key => $value){
			print_r("Key: {$key} \n");
			print_r("Value: \n");
			var_dump($value);
			if(is_array($value)){
				print_r("Is an array\n");
				$name = array_key_first($value);
				$this->firstRowArray[] = $key . "." . $name;
				unset($value[$name]);
				$newFirstKey = array_key_first($value);
				$newKey = $key . "." . $newFirstKey;
				$value[$newKey] = $key;
				unset($value[$newFirstKey]);
				var_dump($value);
				$this->buildColumnNames($value);
			} else {
				$this->firstRowArray[] = $key;
				print_r("FirstRowArray: \n");
				var_dump($this->firstRowArray);
			} 
		}
			var_dump($this->firstRowArray);
			$firstRow = implode(",", $this->firstRowArray);
			//print_r("FirstRow: \n");
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


