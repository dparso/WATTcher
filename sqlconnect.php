<?php

function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

$time_start = microtime_float();

// Read data from file
$lines = file('data.txt');


if (count($lines) <= 0) {
	die("No data in file!\n");
}

//$servername = "turing.bowdoin.edu";
$servername = "localhost";
$username = "energydata";
$password = "zxZbLKC5fdvNPOpw";
$dbname = "energydata";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error . "\n");
}

$sql = "";
$values = array();

$valid = true;
$insertValues = "";
if(count($lines) > 0) {
	parse_str($lines[0], $output);
	$meterID = $output['meter_id'];
}

for($i = 0; $i < count($lines); $i++) {
	if(!(strlen($lines[$i]) > 1)) {
		continue;
	}
	// get name and value from data.txt
	parse_str($lines[$i], $output);

	$value = $output['value'];

	$timeStamp = $output['timestamp'];
	$insertValues .= "INSERT INTO Data (METER_ID, VALUE, TIMESTAMP)\nVALUES ('$meterID', $value, STR_TO_DATE('$timeStamp', '%Y-%m-%d %H:%i:%s'));";
}

$insertNames = "INSERT INTO Labels (METER_ID, LABEL)\nVALUES ('$meterID', '$meterID');";
if(!isset($meterID) || $meterID == "") {
	die("Incorrect meter id\n");
}

if($conn->query($insertNames) === TRUE) {
	echo "Added new meter $meterID to Labels.\n";
} else {
	echo "Meter $meterID already exists.\n";
}

if($conn->multi_query($insertValues) === TRUE) {
	echo "Inserted values.\n";
} else {
	echo "Error: " . $insertValues . "<br>" . $conn->error . "\n";
}

$conn->close();
$time_end = microtime_float();
$time = $time_end - $time_start;

//file_put_contents("timing.txt", $time . "\n", FILE_APPEND);

?>
