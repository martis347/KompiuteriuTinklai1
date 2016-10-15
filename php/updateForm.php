<?php
$name = $_POST["name"];
$lastName = $_POST['lastName'];
$userUsername = $_POST['username'];
$userType = $_POST['accountType'];

include 'config.php';


// Create connection
$conn = new mysqli($db_config['servername'], $db_config['username'], $db_config['password'], $db_config['dbname']);


if ($conn->connect_error) {
	echo "connectionError";
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE user JOIN authentication_token on token = '" . $_COOKIE["authToken"] . "'  SET name='" . $name . "', lastName='" . $lastName . "', username='" . $userUsername . "' WHERE user.id=authentication_token.userId";
$result = $conn->query($sql);

$conn->close();
?>