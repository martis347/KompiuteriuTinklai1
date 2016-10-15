<?php
error_reporting(0);
?>

<?php
include 'config.php';


// Create connection
$conn = new mysqli($db_config['servername'], $db_config['username'], $db_config['password'], $db_config['dbname']);
$conn->set_charset("utf8");

if ($conn->connect_error) {
	echo "connectionError";
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT sensorName, temperature, date FROM sensor_history JOIN authentication_token ON token = '" . $_COOKIE['authToken'] . "' WHERE authentication_token.userId = sensor_history.userId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
     // output data of each row
     while($row = $result->fetch_assoc()) {
         printf("%s %s %s ", $row["sensorName"], $row["temperature"], $row["date"]);
     }
} else {
     echo "0 results";
}

$conn->close();
?>  
