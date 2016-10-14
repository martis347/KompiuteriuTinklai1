<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "administration";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
	echo "connectionError";
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT name, lastName, username, accountType FROM user JOIN authentication_token on token = '" . $_COOKIE['authToken'] . "' WHERE authentication_token.userId = user.id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
     // output data of each row
     while($row = $result->fetch_assoc()) {
         printf("%s %s %s %s", $row["name"], $row["lastName"], $row["username"], $row["accountType"]);
     }
} else {
     echo "0 results";
}

$conn->close();
?>