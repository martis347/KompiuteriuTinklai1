<?php
$sensorNames = $_REQUEST['sensorNames'];
$values = $_REQUEST['values'];

$stack = array();

include 'config.php';
$conn = new mysqli($db_config['servername'], $db_config['username'], $db_config['password'], $db_config['dbname']);
$conn->set_charset("utf8");
for($i = 0; $i< count($values); $i++)
{
	array_push($stack, GetData($sensorNames[$i], $values[$i]));
}

for($i = 0; $i< count($stack); $i++)
{
	printf("%s ", $stack[$i][1]);
}

CheckRules($stack);


function GetData($arg1, $arg2)
{
	return array($arg1, $arg2);
}

function CheckRules($values)
{
include 'config.php';
$conn = new mysqli($db_config['servername'], $db_config['username'], $db_config['password'], $db_config['dbname']);
$conn->set_charset("utf8");
$sql = "SELECT rule FROM sensor_rules JOIN authentication_token ON token = '" . $_COOKIE['authToken'] . "' WHERE authentication_token.userId = sensor_rules.userId";
$result = $conn->query($sql);
$allPieces = array();
if ($result->num_rows > 0) {
     // output data of each row
     while($row = $result->fetch_assoc()) {
         array_push($allPieces, explode(" ", $row['rule']));
     }
}

for($j = 0; $j < count($allPieces); $j++)
{
	

	$leftEqualitySide = array();
	$rightEqualitySide = array();
	$comparer = "";
	$delta = -1;

	


	$leftDone = false;
	$rightDone = false;

	$compareDelta = false;
	for($i = 0; $i < count($allPieces[$j]); $i++)
	{
		if(($allPieces[$j][$i] == "<" || $allPieces[$j][$i] == ">") && !$leftDone)
		{
			$leftDone = true;
			$comparer = $allPieces[$j][$i];
		}
		else if(!$leftDone && !in_array($allPieces[$j][$i], array('>', '<', '[', ']', ':'), true ))
		{
			array_push($leftEqualitySide, $allPieces[$j][$i]);
		}
		else if(($allPieces[$j][$i] == ":") && !$rightDone && $leftDone)
		{
			$rightDone = true;
			$compareDelta = true;
		}
		else if(!$rightDone && $leftDone && !in_array($allPieces[$j][$i], array('>', '<', '[', ']', ':'), true ))
		{
			array_push($rightEqualitySide, $allPieces[$j][$i]);
		}
		else if($compareDelta && $leftDone && $rightDone)
		{
			$delta = $allPieces[$j][$i];
		}
	}
	
	if($delta == -1)
	{
		$leftSum = 0;
		$leftCount = 0;
		
		foreach($values as $value)
		{
			foreach($leftEqualitySide as $item)
			{
				if($value[0] == $item)
				{
					$leftSum += $value[1];
					$leftCount++;
				}
			}
		}

		if($comparer == ">")
		{
			if($leftSum/$leftCount > $rightEqualitySide[0])
			{
				printf("A: ");
				for($a=0;$a<count($allPieces[$j]);$a++)
				{
					printf("%s ", $allPieces[$j][$a]);
				}
				//printf("\n\n");
			}
		}
		if($comparer == "<")
		{
			if($leftSum/$leftCount < $rightEqualitySide[0])
			{
				printf("A: ");
				for($a=0;$a<count($allPieces[$j]);$a++)
				{
					printf("%s ", $allPieces[$j][$a]);
				}
				//printf("\n\n");
			}
		}
	}
	else
	{
		$leftSum = 0;
		$leftCount = 0;
		$rightSum = 0;
		$rightCount = 0;
		
		foreach($values as $value)
		{
			foreach($leftEqualitySide as $item)
			{
				if($value[0] == $item)
				{
					$leftSum += $value[1];
					$leftCount++;
				}
			}
		}
		
		foreach($values as $value)
		{
			foreach($rightEqualitySide as $item)
			{
				if($value[0] == $item)
				{
					$rightSum += $value[1];
					$rightCount++;
				}
			}
		}
		
		if($comparer == ">")
		{
			if(($leftSum/$leftCount - $rightSum/$rightCount) > $delta)
			{
				printf("A: ");
				for($a=0;$a<count($allPieces[$j]);$a++)
				{
					printf("%s ", $allPieces[$j][$a]);
				}
			}
		}
		if($comparer == "<")
		{
			if(($rightSum/$rightCount - $leftSum/$leftCount) > $delta)
			{
				printf("A: ");
				for($a=0;$a<count($allPieces[$j]);$a++)
				{
					printf("%s ", $allPieces[$j][$a]);
				}
				//printf("\n\n");
			}
		}
		
	}
	
	//echo "Left: ";
	foreach($leftEqualitySide as $item)
	{
		//printf("%s ", $item);
	}
	//echo "right: ";
	foreach($rightEqualitySide as $item)
	{
		//printf("%s ", $item);
	}
	//printf("\n\n\n");
	//printf("comparer: %s, delta: %s\n", $comparer, $delta);
	
}
}
?>  
