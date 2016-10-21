<?php
require_once 'login.php';

$fileName="sentence_level_similarity.csv";
$fp=fopen($fileName,"r");
$count=0;

while(($details = fgets($fp))!=null){
	$count=$count+1;
	$details=trim($details);
	$arr=explode("=>",$details);
	$query="INSERT INTO `sentencelevelsimilarity`(`FirstDocId`, `FirstSentenceId`, `FirstSentenceTokens`, `SecondDocId`, `SecondSentenceId`, `SecondSentenceTokens`, `LDAScore`, `CosineScore`) VALUES ('".$arr[1]."','".$arr[2]."','".$arr[3]."','".$arr[4]."','".$arr[5]."','".$arr[6]."','".$arr[7]."','".$arr[8]."')";
	echo $query."<br/>";
	$result=mysql_query($query);	
	if(!$result)
		echo mysql_error()."<br/>";
	//echo $result;
	//break;
	
}

fclose($fp);
?>