<?php
error_reporting(0);
?>


<?php
$userUsername = $_REQUEST['username'];		
$userPassword = $_REQUEST['password'];

include 'config.php';
// Create connection
$conn = new mysqli($db_config['servername'], $db_config['username'], $db_config['password'], $db_config['dbname']);
// Check connection
if ($conn->connect_error) {
	echo "connectionError";
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id FROM user WHERE username='" . $userUsername . "' AND password='" . crypt($userPassword, 'hashcode') . "'";
$result = $conn->query($sql);

$userId = $result->fetch_assoc()["id"];

$success = !is_null($userId);
if($success)
{
	$userToken = uniqid();
	setcookie("authToken", $userToken, 0, '/', 'localhost');
	$sql = "DELETE FROM authentication_token WHERE userId = '" . $userId . "'";
	$conn->query($sql);
	
	$time = date('Y-m-d h:i:s', strtotime("+10 minutes"));
	
	$sql = "INSERT INTO authentication_token (token, userId, endTime) VALUES ('" . $userToken . "', '" . $userId . "', '" . $time . "')";

	$conn->query($sql);
	printf("%s","success");
}
else
{
	printf("%s","failed");
}
$conn->close();


?>  
