<!-- Adapted with permission from https://www.w3schools.com/w3css/w3css_templates.asp -->
<!DOCTYPE html>
<html>
<title>WATTcher Devices</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif}
.w3-bar,h1,button {font-family: "Montserrat", sans-serif}
.fa-anchor,.fa-coffee {font-size:200px}

table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}

</style>
<body>

<!-- Navbar -->
<div class="w3-top">
  <div class="w3-bar w3-red w3-card-2 w3-left-align w3-large">
    <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-red" href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    <a href="index.html" class="w3-bar-item w3-button w3-padding-large w3-hover-white">Home</a>
    <a href="my_devices.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-white">My Devices</a>
    <a href="device_setup.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Device Setup</a>
    <a href="support.html" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Support</a>
  </div>

  <!-- Navbar on small screens -->
  <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium w3-large">
    <a href="my_devices.php" class="w3-bar-item w3-button w3-padding-large">My Devices</a>
    <a href="device_setup.php" class="w3-bar-item w3-button w3-padding-large">Device Setup</a>
    <a href="support.html" class="w3-bar-item w3-button w3-padding-large">Support</a>
  </div>
</div>
<!-- Header -->
<header class="w3-container w3-red w3-center" style="padding:128px 16px">
  <h1 class="w3-margin w3-jumbo">My Devices</h1>
  <p class="w3-xlarge">Manage and monitor your devices.</p>
</header>

<?php
	// check POST values and update labels if necessary
	foreach($_POST as $key => $value) {
		if(preg_match('/([0-9])_([0-9])/', $key, $matches)) {
			$meter_id = $matches[1] . "." . $matches[2];
			$label = $value;

			// insert into database
			$servername = "localhost";
			$username = "energydata";
			$password = "zxZbLKC5fdvNPOpw";
			$dbname = "energydata";
			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);

			// sanitize input
			$label = $conn->real_escape_string($label);
			// Check connection
			if ($conn->connect_error) {
			        die("Connection failed: " . $conn->connect_error . "\n");
			}
			$insert = "INSERT INTO Labels (METER_ID, LABEL)\nVALUES ('$meter_id', '$label') ON DUPLICATE KEY UPDATE LABEL='$label';";
			$conn->query($insert);
		}
	}
?>

<!-- First Grid -->

<div class="w3-row-padding w3-padding-64 w3-container">
  <div class="w3-content">
    <div class="w3-twothird">
      <h1>Control Your Devices</h1>
      <h5 class="w3-padding-32">From here, you can access, view, and control any devices you've set up.</h5>
    </div>
  </div>
</div>

<?php
	session_start();

	if (isset($_GET['table'])) {
		$_SESSION['table'] = $_GET['table'];
	}
	
	if (isset($_GET['time'])) {
		$_SESSION['time'] = $_GET['time'];
	}

	echo '<a name="table_top"></a>';
	include 'tables.php';
?>

<div style="margin-left:25%" id="chart-container">Fetching data...</div>
<script id=scrpt1 src="charts/js/jquery-3.2.1.js"></script>
<script id=scrpt2 src="charts/js/fusioncharts.js"></script>
<script id=scrpt3 src="charts/js/fusioncharts.charts.js"></script>
<script id=scrpt4 src="charts/js/themes/fusioncharts.theme.zune.js"></script>
<script id=scrpt5 src="charts/js/app.js"></script>

<!-- Footer -->
<footer class="w3-container w3-padding-64 w3-center w3-opacity">  
 <!-- <div class="w3-xlarge w3-padding-32">
    <i class="fa fa-facebook-official w3-hover-opacity"></i>
    <i class="fa fa-instagram w3-hover-opacity"></i>
    <i class="fa fa-snapchat w3-hover-opacity"></i>
    <i class="fa fa-pinterest-p w3-hover-opacity"></i>
    <i class="fa fa-twitter w3-hover-opacity"></i>
    <i class="fa fa-linkedin w3-hover-opacity"></i>
 </div>-->
 <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
</footer>

<script>
// Used to toggle the menu on small screens when clicking on the menu button
function myFunction() {
    var x = document.getElementById("navDemo");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else {
        x.className = x.className.replace(" w3-show", "");
    }
}

function setDeviceToShow() {
	
	var table = document.getElementById("deviceTable");
	var newRow = table.insertRow(1);
	var cell1 = newRow.insertCell(0);
	var cell2 = newRow.insertCell(1);
	var cell3 = newRow.insertCell(2);
	cell1.innerHTML = "NEWCELL1";
	cell2.innerHTML = "NEWCELL2";
	cell3.innerHTML = "NEWCELL3";
}

function post(path, params, method) {
	// https://stackoverflow.com/questions/133925/javascript-post-request-like-a-form-submit
	method = method || "post";
	var form = document.createElement("form");
	form.setAttribute("method", method);
	form.setAttribute("action", path);
	
	for(var key in params) {
		if(params.hasOwnProperty(key)) {
			var hiddenField = document.createElement("input");
			hiddenField.setAttribute("type", "hidden");
			hiddenField.setAttribute("name", key);
			hiddenField.setAttribute("value", params[key]);
			form.appendChild(hiddenField);
		}
	}
	
	document.body.appendChild(form);
	form.submit();
}
</script>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
</body>
</html>
