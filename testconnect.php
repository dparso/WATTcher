<!DOCTYPE html>
<html>
<body>

<?php

$servername = "turing.bowdoin.edu";
$username = "energydata";
$password = "zxZbLKC5fdvNPOpw";
$dbname = "energydata";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error . "\n");
}

$sql = "SELECT ID, METER_ID, VALUE, TIMESTAMP FROM Data";
$result = $conn->query($sql);

if($result->num_rows > 0) {
	// output data of each row
	while($row = $result->fetch_assoc()) {
		echo "ID: " . $row["METER_ID"] . " = " . $row["VALUE"] . "<br>\n";
	}
} else {
	echo "0 results.\n";
}

$conn->close();
?>

</body>
</html>
