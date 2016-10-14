<?php
$sensorNames = $_REQUEST['sensorNames'];
$values = $_REQUEST['values'];

$stack = array();



for($i = 0; $i< count($sensorNames); $i++)
{
	array_push($stack, GetData($sensorNames[$i], $values[$i%2]));
}

for($i = 0; $i< count($stack); $i++)
{
	printf("%s ", $stack[$i]);
}

function GetData($arg1, $arg2)
{
	return $arg2;
}
?>  
