<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "administration";

$sensorNames = $_REQUEST['sensors'];

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
	echo "connectionError";
    die("Connection failed: " . $conn->connect_error);
}

foreach($sensorNames as $sensor){
	$sql = "DELETE ss FROM sensors AS ss JOIN authentication_token AS aatt ON aatt.token = '" . $_COOKIE['authToken'] . "' WHERE ss.name='" . $sensor . "'";	echo $sql;
	$result = $conn->query($sql);
}

$conn->close();
?>