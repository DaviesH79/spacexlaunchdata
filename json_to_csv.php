<?php

class Json_to_csv
{

    public $columnNameArray = [];
    public $firstRow = '';
    public $rows = [];
    public $columnValue = '';
    public $count;

    public function execute()
    {
        $data = $this->readFileContents();
        $formattedData = $this->formatData($data);
        $this->buildColumnNames($formattedData[0]);
        $this->buildRows($formattedData);
    }

		/** use columnNames to build the row data 
			@param $data array cleaned up data
		 **/
    public function buildRows($data)
    {
        $dataLength = count($data);
        $columns = $this->columnNameArray;
        $count = 0;
        while ($count < $dataLength) {
            foreach ($columns as $column) {
                $this->getNestedValues($data[$count], $count, $column);
            }
            $count += 1;
        }
        $final = [];
        foreach ($this->rows as $row){
            $docRow = implode(',', $row);
            $final[] = $docRow;
        }
        $firstRow[] = $this->firstRow;
        $finalFinal = array_merge($firstRow, $final);
        $csv = (implode("\n", $finalFinal));
        file_put_contents('launch.csv', $csv);
    }
		
		/** using recursion, dig into the nested data
 			@param $data array
			@param $count int
			@param $column mixed - could be string, could be array
		**/	
    public function getNestedValues($data, $count, $column)
    {
				$columnDataArray = [];
				$dataToString = '';
        if (isset($data[$column]) && is_array($data[$column])) {
            $dataArray = $data[$column];
            foreach ($dataArray as $columnData){
                $columnDataArray[] = $columnData;
            }
            // if we have data, concatenate into single string
            if ($columnDataArray){
                $dataToString = implode(",", $columnDataArray);
            }
            $this->rows[$count][] = '"' . $dataToString . '"';
            return;
        } elseif (isset($data[$column])){
            $this->columnValue = $data[$column];
            $this->rows[$count][] = $this->columnValue;
            return;
        } elseif (strpos($column, '.' )){
            $columnName = explode('.', $column, 2);
            $this->getNestedValues($data[$columnName[0]], $count, $columnName[1]);
        }
    }

		/** build the column names by iterating data and using recursion for nested data 
			@param $array array
		**/
    public function buildColumnNames($array)
    {
        // iterate array to find all columns
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                // get the first key of the array to build new column name
                if (!empty(array_key_first($value))) {
                    $name = array_key_first($value);
                    // build new column name
                    $this->columnNameArray[] = $key . "." . $name;
                    // remove first array key
                    unset($value[$name]);
                    // get next key
                    $newFirstKey = array_key_first($value);
                    if(!empty($newFirstKey)){
                        // build nested key
                        $newKey = $key . "." . $newFirstKey;
                        // set new key
                        $value[$newKey] = $key;
                        // remove next array key
                        unset($value[$newFirstKey]);
                        // pass new array value to this function
                        $this->buildColumnNames($value);
                    }
                } else {
                    $this->columnNameArray[] = $key;
                }
            } else {
                $this->columnNameArray[] = $key;
            }
        }
        $firstRow = implode(",", $this->columnNameArray);
        $this->firstRow = $firstRow;
    }

    /** Clean up the data 
			@param $data string
			@return $launchData array
		**/
		public function formatData($data)
    {
        $jsonArray = json_decode($data, true);
        $launchData = $jsonArray['data']['launches'];
        return $launchData;
    }

		/** read the file and return its contents **/
    public function readFileContents()
    {
        $data = file_get_contents('launchdata.txt');
        return $data;
    }
}

$convertData = new Json_to_csv();
$convertData->execute();
?>
