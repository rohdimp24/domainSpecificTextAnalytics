<?php
require_once 'login.php';

$domainName="ss";
$tableName="originalsentences";
$fileName="sentences.csv";
$fp=fopen($fileName,"r");
$count=0;

while(($details = fgets($fp))!=null){
	
	$details=trim($details);
	$arrDetails=explode(",",$details);
	//print_r($arrDetails);
	$query="INSERT INTO ".$tableName."(`docId`, `sentenceId`, `sentence`) VALUES ('".(int)$arrDetails[1]."','".(int)$arrDetails[2]."','".$arrDetails[3]."')";
	echo $query."<br/>";
	$result=mysql_query($query);	
	if(!$result)
		echo mysql_error()."<br/>";
	//echo $result;
	//break;
	
}

fclose($fp);
?>