<?php
$sensorName = $_REQUEST['sensor'];

include 'config.php';
// Create connection
$conn = new mysqli($db_config['servername'], $db_config['username'], $db_config['password'], $db_config['dbname']);


if ($conn->connect_error) {
	echo "connectionError";
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO sensors (sensorId, name, userId) SELECT NULL, '" . $sensorName . "', authentication_token.userId FROM authentication_token WHERE token = '" . $_COOKIE['authToken'] . "'";
echo $sql;

$result = $conn->query($sql);

$conn->close();
?>