<?php
require 'DBConnection.php';
class AutoLoader {
	private $csv = "data/data.csv";
	private $csv_data = array();
	private $stateNameCountr = array();
	private $stateCodeName = array();

	public function openCSVFile() {
		if (file_exists($this->csv)) {
			$file = fopen($this->csv, "r");
			while (!feof($file)) {
				$data = fgetcsv($file);
				$this->csv_data[] = $data;
				$arr = (explode("\t", $data[1]));
				$splitPlace = explode("-", $arr[1]);
				// $queryForStateInserts =  "INSERT INTO `wallethub`.`states` (`id`, `name`, `code`) VALUES (NULL, 'alaska', 'ak');"
				$this->stateCodeName[trim($arr[0])][] = array("place" => $splitPlace[0], "population" => $arr[2], "name" => $splitPlace[1]);
				// $this->stateCodeName[trim($arr[0])][] = array("place" => $splitPlace[0], "population" => $arr[2], "name" => $splitPlace[1]);
			}

		} else {
			return false;
		}
	}

	public function insertListOfStates() {
		global $db;
		$queryForStateInserts = "INSERT INTO `wallethub`.`states` (`id`, `name`, `code`) VALUES ";
		foreach ($this->stateCodeName as $key => $value) {
			if (!empty($key) && !empty($value[0]['name'])) {
				$queryForStateInserts = $queryForStateInserts . " (NULL,'" . $value[0]['name'] . "', '" . $key . "'),";

			}

		}
		$queryForStateInserts = substr($queryForStateInserts, 0, strlen($queryForStateInserts) - 1);
		$db->query($queryForStateInserts) || die('error');
		echo 'Query for states has been executed';
	}

	public function insertListOfPopulation() {
		global $db;
		// ini_set('max_execution_time', 300);
		$queryForStateInserts = "INSERT INTO `wallethub`.`population` (`id`, `location`, `slug`,`population`) VALUES ";
		foreach ($this->stateCodeName as $key => $value) {
			if (!empty($key) && !empty($value[0]['name'])) {
				foreach ($value as $keyOfV => $valueOfValue) {
					$queryForStateInserts = "INSERT INTO `wallethub`.`population` (`id`, `location`, `slug`,`population`) VALUES " . " (NULL,'" . $valueOfValue['place'] . "', '" . $key . "','" . $valueOfValue['population'] . "')";
					$db->query($queryForStateInserts) || die('error');
					echo 'Saving Records...';
				}
			}
		}
		echo 'Query for population has been executed';
	}
}
?>