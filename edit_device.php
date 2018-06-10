<!-- Adapted with permission from https://www.w3schools.com/w3css/w3css_templates.asp -->
<!DOCTYPE html>
<html>
<title>WATTcher Configure</title>
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
</style>
<body>

<!-- Navbar -->
<div class="w3-top">
  <div class="w3-bar w3-red w3-card-2 w3-left-align w3-large">
    <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-red" href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    <a href="index.html" class="w3-bar-item w3-button w3-padding-large w3-hover-white">Home</a>
    <a href="my_devices.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">My Devices</a>
    <a href="device_setup.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Device Setup</a>
    <a href="support.html" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-white">Support</a>
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
  <h1 class="w3-margin w3-jumbo">Support</h1>
  <p class="w3-xlarge">Troubleshoot network/device issues.</p>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
  <div class="w3-content">
    <div class="w3-twothird">
      <h1>Diagnose the Problem</h1>
	<ul>
		<li><h5 class="w3-padding-32">Not Able to Connect to Device Wi-Fi</h5></li>
			<ul>
				<li>Make sure you've entered the password "qwerty123" when prompted.</li>
				<li>If you're in range of the device and don't see the network R_PI3 at all or cannot connect, contact <a href="mailto:dparsons@bowdoin.edu?Subject=Device%20Issues" target="_top">Dylan Parsons</a> for support.</li>
			</ul>
		<li><h5 class="w3-padding-32">Device Not Appearing In "My Devices"</h5></li>
			<ul>
				<li>If the setup page didn't say "Successfully connected device",</li>
			</ul>
	</ul>
    </div>
  </div>
</div>


<!-- Footer -->
<footer class="w3-container w3-padding-64 w3-center w3-opacity">  
<!--
  <div class="w3-xlarge w3-padding-32">
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
</script>

</body>
</html>
