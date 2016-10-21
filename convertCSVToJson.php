<?php
require_once('dictionaryItemNew.php');
$arrFinal=array();

#read the csv file
$fp=fopen("keywordMapping_ss_new.csv","r");

while(($details = fgets($fp))!=null){
	$arrDetails=explode(",",$details);
	array_push($arrFinal,new dictionaryItem($arrDetails[1],$arrDetails[2]));
}

fclose($fp);

#save the array to the json
$str=json_encode($arrFinal);

echo $str;

file_put_contents("dictionary.json", $str);



?>