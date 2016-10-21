<?php
require_once 'login.php';
require_once("AnalyzedCase.php");
require_once("dictionaryItem.php");
//read the list of the keywords
$fs=fopen("for_unigram.txt","r");
$arrfinal=array();
while(($strfp = fgets($fs))!=null){
	
	$listItem=explode(" ",$strfp);
	if(isset($listItem[1])&&isset($listItem[2]))
		echo trim($strfp).",";	
		


}


?>