<?php
error_reporting(1);
?>
<?php
$sensorNames = $_REQUEST['sensorNames'];
$values = $_REQUEST['values'];

$stack = array();

include 'config.php';
$conn = new mysqli($db_config['servername'], $db_config['username'], $db_config['password'], $db_config['dbname']);
$conn->set_charset("utf8");
for($i = 0; $i< count($values); $i++)
{
	array_push($stack, array($sensorNames[$i], $values[$i]));
}

for($i = 0; $i< count($stack); $i++)
{	$stack[$i][1] += 0;
	printf("%s ", $stack[$i][1]);

	$sql = "INSERT INTO sensor_history (id, userId, sensorName, temperature, date) SELECT NULL, authentication_token.userId, '" . $stack[$i][0] . "', '" . $stack[$i][1] . "', '" . date('Y-m-d h:i:s') . "' FROM authentication_token WHERE token = '" . $_COOKIE['authToken'] . "'";
	$conn->query($sql);
	printf($sql);
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
	}
	else
	{
		printf("\n\nNo error\n\n");
	}
}
?>  
