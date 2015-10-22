<?php
require 'DBConnection.php';

class Query {
	private $phrase = null;
	private $slug = null;
	private $location = null;

	function sanitizeKeys($val) {
		return trim(rtrim($val));
	}

	function setQuery($keys) {
		if (!empty($keys)) {
			$this->phrase = $this->sanitizeKeys($keys);
		}
		return $this;
	}

	function getKeywords() {
		global $db;
		if (empty($this->phrase)) {
			$arr = array("success" => 0, "message" => "Invalid query pattern");
			return json_encode($arr);
		}
		$this->phrase = $db->real_escape_string($this->phrase);

		$stateResult = $db->query("select `code` from `states` where `name`  like '%" . $this->phrase . "%' or `code` like '%" . $this->phrase . "%' limit 1");
		if ($stateResult->num_rows > 0) {
			$searchPharse = $stateResult->fetch_assoc()['code'];
		} else {
			$searchPharse = $this->phrase;
		}
		$query = "SELECT * FROM `population` WHERE `location` like '%" . $this->phrase . "%' or `slug` like '%" . $searchPharse . "%' order by `population` desc limit 10";
		$result = $db->query($query);
		$response = array();
		while ($row = $result->fetch_assoc()) {
			$response[] = $row;
		}
		$result->free();
		// $db->close();
		sleep(2);
		return json_encode(array("success" => 1, "data" => json_encode($response)));
	}

	function getDetailsData() {
		global $db;
		if (empty($this->phrase)) {
			return null;
		}
		$keys = array();
		if ($this->slug === null) {
			return array("success" => 0, "message" => "No any result found");
		} else {
			// $result = $db->query("select * from `population` where `id`=" . $this->slug);
			$this->slug = $db->real_escape_string($this->slug);
			$x = "select * from `population` where `id` = " . $this->slug;
			$result = $db->query($x) or die($db->error);
			if ($result->num_rows > 0) {
				$searchPharse = $result->fetch_assoc()['slug'];
				$result = $db->query("SELECT *
										FROM `population`
										INNER JOIN `states`
										ON population.slug=states.code where population.id = " . $this->slug);

				return array("success" => 1, "data" => $result->fetch_assoc());
			} else {
				return array("success" => 0, "message" => "No any result found");
			}
		}

		return $this->phrase;
	}

	/**
	 * Sets the value of slug.
	 *
	 * @param mixed $slug the slug
	 *
	 * @return self
	 */
	function _setId($slug) {
		$this->slug = $slug;

		return $this;
	}

	/**
	 * Sets the value of location.
	 *
	 * @param mixed $location the location
	 *
	 * @return self
	 */
	private function _setLocation($location) {
		$this->location = $location;

		return $this;
	}
}