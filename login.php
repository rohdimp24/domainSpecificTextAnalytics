<?php
set_time_limit(0);
$db_hostname='localhost';
$db_database='domainanalysis';
$db_username='root';
$db_password='';

$db_server = mysql_connect($db_hostname, $db_username, $db_password);
if (!$db_server) die("Unable to connect to MYSQL: " . mysql_error());

mysql_select_db($db_database)
or die("Unable to select database: " . mysql_error());
?>
<link rel="stylesheet" href="css/bootstrap.css" />
