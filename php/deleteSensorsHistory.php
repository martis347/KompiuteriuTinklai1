<?php
$sensorNames = $_REQUEST['toDelete'];
include 'config.php';

// Create connection
$conn = new mysqli($db_config['servername'], $db_config['username'], $db_config['password'], $db_config['dbname']);
$conn->set_charset("utf8");

if ($conn->connect_error) {
	echo "connectionError";
    die("Connection failed: " . $conn->connect_error);
}

foreach($sensorNames as $sensor){
	$sql = "DELETE ss FROM sensor_history AS ss JOIN authentication_token AS aatt ON aatt.token = '" . $_COOKIE['authToken'] . "' WHERE ss.sensorName='" . $sensor[0] . "' AND ss.temperature='" . $sensor[1] . "' AND ss.date='" . $sensor[2] . "'";
	$result = $conn->query($sql);
}

$conn->close();
?>