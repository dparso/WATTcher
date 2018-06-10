<?php
	$address="turing.bowdoin.edu";
 	$port=8089;

	set_time_limit (0); 
	if(($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
		echo "Socket creation failed: " . socket_last_error() . "\n";
	}

	if (socket_bind($socket, $address, $port) === false) {
		echo "socket_bind() failed: reason: " . socket_strerror(socket_last_error($socket)) . "\n";
	}

	if (socket_listen($socket, 5) === false) {
		echo "socket_listen() failed: reason: " . socket_strerror(socket_last_error($socket)) . "\n";
		break;
	}
	
	while (true) {
		if(($client = socket_accept($socket)) === false) {
			echo "socket_accept() failed: reason: " . socket_strerror(socket_last_error($socket)) . "\n";
			break;
		}
		
		$lineCount = 0;
		while (true) {
			if(($buf = socket_read($client, 2048, PHP_NORMAL_READ)) === false) {
				echo "socket_read() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
				break;
			}
	
			if(!(strlen($buf)) > 1) {
				echo "Empty entry: skipping.\n";
			} else {
				if(!strcmp($buf, "done")) {
					break;
				}
		
				// add each line to file
				file_put_contents("data.txt", $buf, FILE_APPEND);
				$lineCount++;
			}
		}
	
		// only reset file once all lines have been added and uploaded	
		exec("php sqlconnect.php");
		echo "Stored " . $lineCount . " entries.\n";
		file_put_contents("data.txt", "");
	}

	socket_close($socket); 
?>

