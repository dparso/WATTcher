<?php
// this file monitors the status of devices and notifies
// the email recipient of offline devices

$deviceStates = array();

$servername = "localhost";
$username = "energydata";
$password = "zxZbLKC5fdvNPOpw";
$dbname = "energydata";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error . "\n");
}

while(true) {
	$meterIDList = array();
	
	// get meter_id's from Labels
	$labelQuery = "SELECT METER_ID FROM Labels;";
	$labelResult = $conn->query($labelQuery);
	
	if($labelResult->num_rows > 0) {
	        while($row = $labelResult->fetch_assoc()) {
	                array_push($meterIDList, $row["METER_ID"]);
	        }
	}

	$messages = array();
	if(count($messages) > 0) {
		exit(0);
	}
	$msg = "";
	for($i = 0; $i < count($meterIDList); $i++) {
	
		$activeQuery = "SELECT DISTINCT ID FROM Data WHERE METER_ID = \"$meterIDList[$i]\" AND TIMESTAMP >= DATE_SUB(NOW(), INTERVAL 1 MINUTE);";
		$activeResult = $conn->query($activeQuery);
	
		$currID = $meterIDList[$i];

		$noExist = 0;	
	
		// if there's a result, then the meter is active
		// if the meter's value doesn't match the old value, notify of an event
		if($activeResult->num_rows > 0) {
			if(array_key_exists($currID, $deviceStates)) {
				// this meter existed before: check against its previous value
				if($deviceStates[$currID] != 1) {
					// this device was inactive, but is now active
					$msg = $currID . " has become active.";
					$deviceStates[$currID] = 1;
				}
			} else {
				$noExist = 1;
				$deviceStates[$currID] = 1;
				$msg = $currID . " has been created (active).";
			}
		} else {
			if(array_key_exists($currID, $deviceStates)) {
	                        if($deviceStates[$currID] != 0) {
	                                // this device was active, but is now inactive
	                                $deviceStates[$currID] = 0;
					$msg = $currID . " has become inactive.";
	
	                        }
			} else {
				$noExist = 1;
				$deviceStates[$currID] = 0;
				$msg = $currID . " has been created (inactive).";
			}
		}
		if($msg != "") {	
			array_push($messages, $msg);
			$msg = "";
		}
	}
	
	$mailMsg = "The following states have changed (" . count($messages) . " reported):\n\n";
	for($i = 0; $i < count($messages); $i++) {
		$mailMsg .= $messages[$i] . "\n";
	}
	$mailMsg .= "\nEnd of message.\n";
		
	if(count($messages) > 0) {
		$mailMsg = wordwrap($mailMsg, 70);
		echo $mailMsg;	
		mail("dparsons@bowdoin.edu", "WATTcher Notification", $mailMsg);
	}
	// wait for 5 minutes before checking again
	sleep(300);
}

$conn->close();
?>
