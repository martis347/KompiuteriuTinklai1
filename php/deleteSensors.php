<?php
error_reporting(0);
?>
<?php
$sensorNames = $_REQUEST['sensors'];
include 'config.php';

// Create connection
$conn = new mysqli($db_config['servername'], $db_config['username'], $db_config['password'], $db_config['dbname']);
$conn->set_charset("utf8");

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