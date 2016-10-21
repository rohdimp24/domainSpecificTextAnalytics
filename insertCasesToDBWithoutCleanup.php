<?php
require_once 'login.php';

$domainName="ss";
$tableName="original".$domainName;
$fileName="cases_".$domainName.".txt";
$fp=fopen($fileName,"r");
$count=0;

while(($details = fgets($fp))!=null){
	$count=$count+1;
	$details=trim($details);
	if(strlen($details)<5)
		continue;
	$query="INSERT INTO ".$tableName." (`case`) VALUES ('".$details."')";
	//echo $query."<br/>";
	$result=mysql_query($query);	
	if(!$result)
		echo mysql_error()."<br/>";
	//echo $result;
	//break;
	
}

fclose($fp);
?>