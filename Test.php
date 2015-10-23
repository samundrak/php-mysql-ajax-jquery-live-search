
<?php
// require './src/class/AutoLoader.php';
// $autoLoader = new AutoLoader();
// echo '<pre>';
// $autoLoader->openCSVFile();

//To insert population
// $autoLoader->insertListOfPopulation();

//To insert states
// $autoLoader->insertListOfStates();

/*TEST 3:
Given a string:
1,2,3,4,5,6

Create a function that gets the numbers on the left and the right of the given element.
Here are some expected outputs:

pagination(1); // array('prev' => null, 'next' => 2);
pagination(2); // array('prev' => 1, 'next' => 3);
pagination(6); // array('prev' => 5, 'next' => null);

please do so "without" making use of explode() since the string can be comprised of thousands of elements when exploded and that would be slow on the memory.
only use string manipulation functions.
 */
function pagination($index) {
	$index -= 1;
	$string = "1,2,3,4,5";
	$array = array();
	for ($i = 0; $i < strlen($string); $i++) {
		if ($string[$i] != ",") {
			$array[] = $string[$i];
		}
	}

	$page = [];
	$next = ($index + 1) > ((sizeof($array) - 1)) ? 'null' : empty($array[($index + 1)]) ? 'null' : $array[($index + 1)];
	$prev = ($index - 1) < 0 ? 'null' : empty($array[($index - 1)]) ? 'null' : $array[($index - 1)];

	return array('prev' => $prev, 'next' => $next);
}

print_r(pagination(5));
