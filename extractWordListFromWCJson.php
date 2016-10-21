<?php
$db_hostname='localhost';
$db_database='dvirji_mygann';
$db_username='root';
$db_password='';

set_time_limit(0);

$db_server = mysql_connect($db_hostname, $db_username, $db_password);
if (!$db_server) die("Unable to connect to MYSQL: " . mysql_error());

mysql_select_db($db_database)
or die("Unable to select database: " . mysql_error());


/*$query="Select * from AmazonTransactions";
$result=mysql_query($query);
$rowsnum=mysql_num_rows($result);
$arrTransactionIds=array();
for($i=0;$i<15800;$i++)
{
	$row=mysql_fetch_row($result);
	$arr=explode("_", $row[0]);
	
	$insertQuery="INSERT INTO `transactions`(`transactionId`, `productId`) VALUES ('".$arr[0]."','".$arr[1]."')";
	echo $insertQuery."<br/>";
	$resultQuery=mysql_query($insertQuery);
	if(!$resultQuery)
	{
		echo $insertQuery."<br/>";
		echo mysql_error()."<br/>";
	}

}

*/


$fs=fopen("wordcloud_ss_normalized.json","r");
$details="";
while(($strfp = fgets($fs))!=null){
	$details=$strfp;
}

$jsonObj=json_decode($details);
print_r($jsonObj);


for($i=0;$i<100;$i++)
{
	echo $jsonObj[$i][0]."<br/>";
}


//print_r($arrTransactionIds);

?>