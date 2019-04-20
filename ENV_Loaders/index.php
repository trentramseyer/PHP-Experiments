<?php
// Start PHP Session
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$_test = $_GET['test'] ?? 0;


/**
 * Include Composer Files
 */
if($_test > 0){
    if(file_exists(__DIR__.'/vendor/autoload.php')){
        require_once __DIR__.'/vendor/autoload.php';
    } else {
        die("Please run composer");
    }
}


/**
 * Load Environment file
 */
if($_test == 2){
    if(file_exists(__DIR__.'/environment.php')){
        require_once __DIR__.'/environment.php';
    } else {
        die("Could not load environment.php File");
    }
}

/**
 * Load Environment with Symfony
 */
if($_test == 3) {
    if (file_exists(__DIR__ . '/.env')) {
        $dotenv = new \Symfony\Component\Dotenv\Dotenv();
        $dotenv->load(__DIR__ . '/.env');
    } else {
        die("Could not load .env File");
    }
}


/**
 * Load Environment with vlucas/phpdotenv
 */
if($_test == 4) {
    if (file_exists(__DIR__ . '/.env')) {
        $dotenv = \Dotenv\Dotenv::create(__DIR__);
        $dotenv->load();
    } else {
        die("Could not load .env File");
    }
}


/**
 * Output some links
 */
?>
<h3>Tests</h3>
<ol>
    <li><a href="index.php?test=0">No Includes</a></li>
    <li><a href="index.php?test=1">Composer Loaded</a></li>
    <li><a href="index.php?test=2">ENV set with PHP Array</a></li>
    <li><a href="index.php?test=3">.env Loaded with Symfony Dotenv Component</a></li>
    <li><a href="index.php?test=4">.env Loaded with vlucas/phpdotenv Component</a></li>
</ol>


<h3>Load Time and Memory</h3>
<?php

/**
 * Calculate some Time and Memory
 */

$load_time = round((microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]),4);
echo "<p>Load Time is ".$load_time."</p>";

$size = memory_get_usage();
$unit=array('b','kb','mb','gb','tb','pb');
$memory_usage =  @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
echo "<p>Memory Usage ".$memory_usage."</p>";
?>


<h3>Files Included</h3>
<?php


/**
 * Show Files
 */
$included_files = get_included_files();

echo "Total Files: ". count($included_files)."<br>";
foreach ($included_files as $filename) {
    echo $filename. "<br>";
}



/*
 * GENERATE SOME RANDOM ENV VARS
function generateRandomString($length = 10) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

echo "<PRE>";
$x=1;
while($x <= 50) {
    //echo '$_ENV[\''.generateRandomString(). '\']="'.generateRandomString().'";'."\n";
    echo generateRandomString().'='.generateRandomString()."\n";

    $x++;
}
 *
 */
