<?php
require_once 'login.php';

$tableName="autonormalizedss_sentences";
$fileName="sentences.csv";
$fp=fopen($fileName,"r");
$count=0;

while(($details = fgets($fp))!=null){
	
	$details=trim($details);
	$arrDetails=explode(",",$details);
	//print_r($arrDetails);
	$query="Update ".$tableName." set originalDocId='".$arrDetails[1]."' where sno='".$arrDetails[2]."'";
	echo $query."<br/>";
	$result=mysql_query($query);	
	 if(!$result)
	 	echo mysql_error()."<br/>";
	
}

fclose($fp);
?>