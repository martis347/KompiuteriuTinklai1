<?php
error_reporting(0);
?>
<?php
$sensorName = $_REQUEST['sensor'];
$userUsername = $_REQUEST['username'];	
include 'config.php';
// Create connection
$conn = new mysqli($db_config['servername'], $db_config['username'], $db_config['password'], $db_config['dbname']);
$conn->set_charset("utf8");

if ($conn->connect_error) {
	echo "connectionError";
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO sensors (sensorId, name, userId) SELECT NULL, '" . $sensorName . "', authentication_token.userId FROM authentication_token WHERE token = '" . $_COOKIE['authToken'] . "'";
if($userUsername != null)
{
	$sql = "INSERT INTO sensors (sensorId, name, userId) SELECT NULL, '" . $sensorName . "', user.id FROM user WHERE user.username = '" . $userUsername . "'";
	//echo $sql;
}
echo $sql;

$result = $conn->query($sql);

$conn->close();
?>