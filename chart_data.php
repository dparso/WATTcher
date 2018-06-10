<?php
session_start();

$deviceName = $_SESSION['table'];
$pi_id = substr($deviceName, 0, 1);
$time = $_SESSION['time'];

$servername = "localhost";
$username = "energydata";
$password = "zxZbLKC5fdvNPOpw";
$dbname = "energydata";
$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error . "\n");
}

// get an ID cutoff: faster than doing timestamp checking for every entry
switch($time) {
	case "hr":
		$limitQuery = "SELECT ID FROM Data WHERE METER_ID = \"$deviceName\" AND TIMESTAMP >= DATE_SUB(NOW(), INTERVAL 1 HOUR) LIMIT 1;"; 
		break;
	case "dy":
		$limitQuery = "SELECT ID FROM Data WHERE METER_ID = \"$deviceName\" AND TIMESTAMP >= DATE_SUB(NOW(), INTERVAL 1 DAY) LIMIT 1;"; 
		break;
	case "wk":
		$limitQuery = "SELECT ID FROM Data WHERE METER_ID = \"$deviceName\" AND TIMESTAMP >= DATE_SUB(NOW(), INTERVAL 7 DAY) LIMIT 1;"; 
		break;
	case "mo":
		$limitQuery = "SELECT ID FROM Data WHERE METER_ID = \"$deviceName\" AND TIMESTAMP >= DATE_SUB(NOW(), INTERVAL 31 DAY) LIMIT 1;"; 
		break;
	case "yr":
		$limitQuery = "SELECT ID FROM Data WHERE METER_ID = \"$deviceName\" AND TIMESTAMP >= DATE_SUB(NOW(), INTERVAL 365 DAY) LIMIT 1;"; 
		break;
	default:
		$limitQuery = "SELECT ID FROM Data WHERE METER_ID = \"$deviceName\" AND TIMESTAMP >= DATE_SUB(NOW(), INTERVAL 1 HOUR) LIMIT 1;"; 
		break;
}

$limitResult = $conn->query($limitQuery);
if($limitResult->num_rows > 0) {
        while($row = $limitResult->fetch_assoc()) {
                $ID_Limit = $row["ID"];
        }
}
		
switch($time) {
	case "hr":
		$sql = "SELECT VALUE, TIMESTAMP FROM Data WHERE METER_ID = \"$deviceName\" AND ID > $ID_Limit;";
		break;
	case "dy":
		$sql = "SELECT VALUE, TIMESTAMP FROM Data WHERE METER_ID = \"$deviceName\" AND ID > $ID_Limit;";
		break;
	case "wk":
		$sql = "SELECT VALUE, TIMESTAMP FROM Data WHERE METER_ID = \"$deviceName\" AND ID > $ID_Limit;";
		break;
	case "mo":
		$sql = "SELECT VALUE, TIMESTAMP FROM Data WHERE METER_ID = \"$deviceName\" AND ID > $ID_Limit;";
		break;
	case "yr":
		$sql = "SELECT VALUE, TIMESTAMP FROM Data WHERE METER_ID = \"$deviceName\" AND ID > $ID_Limit;";
		break;
	default:		
		$sql = "SELECT VALUE, TIMESTAMP FROM Data WHERE METER_ID = \"$deviceName\" AND ID > $ID_Limit;";
		break;
}

$result = $conn->query($sql);
$labelQuery = "SELECT LABEL FROM Labels WHERE METER_ID = \"$deviceName\";";
$labelResult = $conn->query($labelQuery);

if($labelResult->num_rows > 0) {
	while($row = $labelResult->fetch_assoc()) {
		$label = $row["LABEL"];
	}
}


$jsonArray = array();

$count = 0;
$oldVal = 0;
if($result->num_rows > 0) {
	// output data of each row
	while($row = $result->fetch_assoc()) {
		$count++;
		$newVal = $row["VALUE"];
		if(abs($newVal - $oldVal) < 5 && $count % ($result->num_rows / 20.0) != 0) {
			continue;
		}
	
		$jsonArrayItem = array();
		$jsonArrayItem['label'] = $row["TIMESTAMP"];
		$jsonArrayItem['value'] = $newVal;
		$jsonArrayItem['id'] = $pi_id;
		if(isset($label)) {
			$jsonArrayItem['name_label'] = $label;
		} else {
			$jsonArrayItem['name_label'] = $pi_id;
		}
		array_push($jsonArray, $jsonArrayItem);
		
		$oldVal = $newVal;
	}
}

$conn->close();

header('Content-type: application/json');

echo json_encode($jsonArray);

?>
