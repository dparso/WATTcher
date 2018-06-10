<!-- Included in my_devices.php to show up-to-date tables -->
<?php
//$tableName = $_POST['tableName'];

$servername = "localhost";
$username = "energydata";
$password = "zxZbLKC5fdvNPOpw";
$dbname = "energydata";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error . "\n");
}

// get names of devices 
$getValues = "SELECT DISTINCT METER_ID FROM Labels;";
$result = $conn->query($getValues);
$values = array();
if($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$meter_id = $row["METER_ID"];
		$id = substr($meter_id, 0, 1);
		$value = 2;
		$tuple = array($value, $id);
		

		if(array_key_exists($meter_id, $values)) {
			array_push($values[$meter_id], $tuple);
		} else {
			$values[$meter_id] = [$tuple];
		}
		
	}
}

$deviceNames = array();
$deviceSerials = array();
foreach($values as $key => $set) {
	array_push($deviceNames, $key);
	array_push($deviceSerials, $set[0][1]);
}

$tableString = "";
$dropdownString = "";
$results = array();


$deviceLabels = array();
$devicesActive = array();

for($i = 0; $i < count($deviceNames); $i++) {
	$labelQuery = "SELECT DISTINCT LABEL FROM Labels WHERE METER_ID = \"$deviceNames[$i]\"";
	$activeQuery = "SELECT DISTINCT ID FROM Data WHERE METER_ID = \"$deviceNames[$i]\" AND TIMESTAMP >= DATE_SUB(NOW(), INTERVAL 2 MINUTE);";

	$labelResult = $conn->query($labelQuery);
	$activeResult = $conn->query($activeQuery);

	$currLabel = $deviceNames[$i];
	if($labelResult->num_rows > 0) {
		while($row = $labelResult->fetch_assoc()) {
			$label = $row["LABEL"];
			$currLabel = $label;
			array_push($deviceLabels, $label);
		}
	}

	if($activeResult->num_rows > 0) {
		array_push($devicesActive, "Active");
	} else {
		array_push($devicesActive, "Inactive");
	}

	// allow special characters in device name
	$nameString = rawurlencode($deviceNames[$i]);
	$tableString .=
		"<tr>
			<td>
			<form method=\"post\">
				<div class=\"form-group\">
					
					<input type=\"text\" class=\"form-control\" value= \"$currLabel\" name=\"$deviceNames[$i]\">
				</div>
			</form>
			</td>
			<td>$deviceNames[$i]</td>
			<td>$deviceSerials[$i]</td>
			<td>$devicesActive[$i]</td>
		</tr>";
	$dropdownString .= "
		<a href=my_devices.php?table=$nameString#table_top class=\"w3-bar-item w3-button\">" . $currLabel . "</a>";
}

// HTML device table
echo '
        <div class=" w3-center">
                <table id="deviceTable">
                <caption>Connected Devices</caption>
                        <tr>
                                <th>Device Name</th>
                                <th>Meter ID</th>
                                <th>WATTcher ID</th>
				<th>Status</th>
                        </tr>
			' .
			$tableString
			. '
                </table>
        </div>

        <div class="w3-bar w3-light-grey">
                <!-- <a href="#" class="w3-bar-item w3-button">Home</a> -->
                <div class="w3-dropdown-hover">
                        <button class="w3-button">Show Devices <i class="fa fa-caret-down"></i></button>
			<div class="w3-dropdown-content w3-bar-block w3-card-4">
				' . $dropdownString . '
			</div>
                </div>

                <div class="w3-dropdown-hover">
                        <button class="w3-button">Options <i class="fa fa-caret-down"></i></button>
                        <div class="w3-dropdown-content w3-bar-block w3-card-4">
                                <a href="device_setup.php" class="w3-bar-item w3-button">Edit Devices</a>
    
			</div>		
		</div>
		<div class="w3-dropdown-hover">
                        <button class="w3-button">Timeline <i class="fa fa-caret-down"></i></button>
                        <div class="w3-dropdown-content w3-bar-block w3-card-4">
                                <a href="my_devices.php?time=hr#table_top" class="w3-bar-item w3-button">Last Hour</a>
                                <a href="my_devices.php?time=dy#table_top" class="w3-bar-item w3-button">Last Day</a>
                                <a href="my_devices.php?time=wk#table_top" class="w3-bar-item w3-button">Last Week</a>
                                <a href="my_devices.php?time=mo#table_top" class="w3-bar-item w3-button">Last Month</a>
                                <a href="my_devices.php?time=yr#table_top" class="w3-bar-item w3-button">Last Year</a>
                        </div>          
                </div>
		
        </div>
';


$conn->close();
?>
