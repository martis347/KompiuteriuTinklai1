<?php
error_reporting(0);
?>
<?php 
$db_config = array(
  'servername' => 'db.if.ktu.lt',
  'username' => 'markan2',
  'password' => 'Fe5keiKoob6Ohk6o',
  'dbname' => 'markan2');
  if($_SERVER['SERVER_NAME'] == "localhost")
	{
		$db_config = array(
			'servername' => 'localhost',
			'username' => 'admin',
			'password' => 'admin',
			'dbname' => 'administration');
	}
	
?>