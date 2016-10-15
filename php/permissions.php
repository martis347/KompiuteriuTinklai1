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

$sql = "SELECT rightName FROM account_rights JOIN authentication_token on token = '" . $_COOKIE["authToken"] . "' JOIN user on user.id = authentication_token.userId WHERE user.accountType=account_rights.accountType";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
     // output data of each row
     while($row = $result->fetch_assoc()) {
         printf("%s ", $row["rightName"]);
     }
} else {
     echo "0 results";
}

$conn->close();
?>  
