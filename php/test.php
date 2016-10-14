<?php
$datetime1 = date('Y-m-d h:i:s');
$datetime2 = date('2016-10-14 10:27:52');


$ts1 = strtotime($datetime1);
$ts2 = strtotime($datetime2);

$seconds_diff = $ts2 - $ts1;
echo $datetime2;
?>