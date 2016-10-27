<?php
error_reporting(0);
?>
<?php
$rule = $_REQUEST['rule'];

include 'config.php';
// Create connection
$conn = new mysqli($db_config['servername'], $db_config['username'], $db_config['password'], $db_config['dbname']);

$conn->set_charset("utf8");

if ($conn->connect_error) {
	echo "connectionError";
    die("Connection failed: " . $conn->connect_error);
}

$sql = "DELETE sr FROM sensor_rules AS sr JOIN authentication_token AS at ON at.token = '" . $_COOKIE['authToken'] . "' WHERE at.userId = sr.userId AND sr.rule='" . $rule . "'";
echo $sql;

$result = $conn->query($sql);

$conn->close();
?>