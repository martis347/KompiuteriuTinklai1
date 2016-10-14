<?php
$name = $_POST["name"];
$lastName = $_POST['lastName'];
$userUsername = $_POST['username'];
$userType = $_POST['accountType'];

$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "administration";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
	echo "connectionError";
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE user JOIN authentication_token on token = '" . $_COOKIE["authToken"] . "'  SET name='" . $name . "', lastName='" . $lastName . "', username='" . $userUsername . "' WHERE user.id=authentication_token.userId";
$result = $conn->query($sql);

$conn->close();
?>