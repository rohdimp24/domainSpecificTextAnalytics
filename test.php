<?php
#read the file in the csv format
require_once("AnalyzedCase.php");
require_once("dictionaryItem.php");

$fs=fopen("keywordMapping.csv","r");
$arrUnigramDict=array();
while(($strfp = fgets($fs))!=null){
	if(!strlen(trim($strfp))==0)
	{
		list($sno,$variant,$canonical)=explode(",",$strfp);

		$obj=new dictionaryItem(strtolower($variant),strtolower($canonical));
		array_push($arrUnigramDict,$obj);
	}
}
fclose($fs);


print_r($arrUnigramDict);

?>