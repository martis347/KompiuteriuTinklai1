<?php
$sensorNames = $_REQUEST['sensorNames'];
$values = $_REQUEST['values'];

$stack = array();

include 'config.php';
$conn = new mysqli($db_config['servername'], $db_config['username'], $db_config['password'], $db_config['dbname']);
$conn->set_charset("utf8");
for($i = 0; $i< count($sensorNames); $i++)
{
	array_push($stack, GetData($sensorNames[$i], $values[$i%2]));
}

for($i = 0; $i< count($stack); $i++)
{
	printf("%s ", $stack[$i][1]);

	$sql = "INSERT INTO sensor_history (id, userId, sensorName, temperature, date) SELECT NULL, authentication_token.userId, '" . $stack[$i][0] . "', '" . $stack[$i][1] . "', '" . date('Y-m-d h:i:s') . "' FROM authentication_token WHERE token = '" . $_COOKIE['authToken'] . "'";
	$conn->query($sql);
}



// Create connection


function GetData($arg1, $arg2)
{
	return array($arg1, $arg2);
}
?>  
