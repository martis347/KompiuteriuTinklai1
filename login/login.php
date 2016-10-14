<?php
error_reporting(0);
?>


<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "administration";

$userUsername = $_REQUEST['username'];		
$userPassword = $_REQUEST['password'];



// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
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

	
	$time = new DateTime(date('Y-m-d h:i:s'));
	$time->add(new DateInterval('PT10M'));
	$stamp = $time->format('Y-m-d h:i:s');
	
	$sql = "INSERT INTO authentication_token (token, userId, endTime) VALUES ('" . $userToken . "', '" . $userId . "', '" . $stamp . "')";
	$conn->query($sql);
	printf("%s","success");
}
else
{
	printf("%s","failed");
}
$conn->close();


?>  
