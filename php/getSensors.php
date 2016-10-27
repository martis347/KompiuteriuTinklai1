<?php
error_reporting(0);
?>
<?php
include 'config.php';

$userUsername = $_REQUEST['username'];	

// Create connection
$conn = new mysqli($db_config['servername'], $db_config['username'], $db_config['password'], $db_config['dbname']);
$conn->set_charset("utf8");

if ($conn->connect_error) {
	echo "connectionError";
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT name FROM sensors JOIN authentication_token on token = '" . $_COOKIE['authToken'] . "' WHERE authentication_token.userId = sensors.userId";

if($userUsername != null)
{
	$sql = "SELECT sensors.name FROM sensors JOIN user on username = '" . $userUsername . "' WHERE user.id = sensors.userId";
	//echo $sql;
}


$result = $conn->query($sql);

if ($result->num_rows > 0) {
     // output data of each row
     while($row = $result->fetch_assoc()) {
         printf("%s ", $row["name"]);
     }
} else {
     echo "0 results";
}

$conn->close();
?>