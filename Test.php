
<?php
require './src/class/AutoLoader.php';
$autoLoader = new AutoLoader();
echo '<pre>';
$autoLoader->openCSVFile();

//To insert population
// $autoLoader->insertListOfPopulation();

//To insert states
// $autoLoader->insertListOfStates();