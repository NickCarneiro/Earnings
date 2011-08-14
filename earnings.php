<?php
session_start();
include("Network.php");

//Configure these settings
//The strings in this associative array are mapped to files in the networks directory
$networks = Array("Cpaway" => 0);
//the POST parameter password must match this string
$username = "username";
$password = "password";
if(isset($_POST['loggedIn'])){
	if(isset($_SESSION['auth'])){
		echo('{"loggedIn": "true"}');	
	} else {
		echo('{"loggedIn": "false"}');
	}
}
else if(isset($_POST['logOut'])){
	unset($_SESSION['auth']);
}
else if(isset($_POST['username'])){
	if($_POST['username'] == $username && $_POST['password'] == $password){
		$_SESSION['auth'] = true;
		echo('{"message": "Login successful."}');
	} else {
		unset($_SESSION['auth']);
		echo('{"error": "Login failed for given credentials."}');
	}
}

else if(isset($_POST['getEarnings'])){
	if(!isset($_SESSION['auth'])){
		echo('{"error": "Not logged in."}');
		die();
	}
	//get earnings for every network in $networks and return as JSON
	$networks = json_decode(file_get_contents("networks.json"));
	foreach($networks as &$network){
		try{
			include("networks/".$network->file_name);
			
			$net = new $network->network_name($network->username, $network->password);
			$earnings_result = $net->getEarnings($_POST['startDate'], $_POST['stopDate']);
			if($earnings_result === false){
				throw new Exception("Could not get earnings for ".$network->network_name);
			}else {
				$network->earnings = $earnings_result;
				
			}			
			
		}
		catch(Exception $e){
			$network->error = $e->getMessage();
		}
		//remove extra data that client doesn't need
		unset($network->file_name);
		unset($network->username);
		unset($network->password);
		
	}

	echo(json_encode($networks));
	
	
}

?>