<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "administration";

$sensorName = $_REQUEST['sensor'];

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
	echo "connectionError";
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO sensors (sensorId, name, userId) SELECT NULL, '" . $sensorName . "', authentication_token.userId FROM authentication_token WHERE token = '" . $_COOKIE['authToken'] . "'";
echo $sql;

$result = $conn->query($sql);

$conn->close();
?>