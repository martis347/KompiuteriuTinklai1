<?php
error_reporting(0);
?>

<?php
include 'config.php';

// Create connection
$conn = new mysqli($db_config['servername'], $db_config['username'], $db_config['password'], $db_config['dbname']);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error) {
	echo "connectionError";
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT userId, endTime FROM authentication_token WHERE token='" . $_COOKIE["authToken"] . "'";

$result = $conn->query($sql);

$row = $result->fetch_assoc();
$userId = $row["userId"];
$endTime = $row["endTime"];

if(!is_null($userId))
{
	$datetime1 = date($endTime);
	$datetime2 = date('Y-m-d h:i:s');


	$ts1 = strtotime($datetime1);
	$ts2 = strtotime($datetime2);

	$seconds_diff = $ts2 - $ts1;
	
	
	if($seconds_diff > 0)
	{
		echo "false";
		printf(" %s", $seconds_diff);
		return "false";
	}
	else
	{
		$time = date('Y-m-d h:i:s', strtotime("+10 minutes"));

		$sql = "UPDATE authentication_token SET endTime = '" . $time . "' WHERE token = '" . $_COOKIE["authToken"] . "'";
		$conn->query($sql);
		echo "true";

		return "true";
	}
	
	
}
echo "false";
return "false";
$conn->close();
?>  
