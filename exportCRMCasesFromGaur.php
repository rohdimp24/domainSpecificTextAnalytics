<?php

require_once 'login.php';

$domainName="ss";
$tableName="original".$domainName;
$fileName="cases_".$domainName.".txt";

$count=0;


$fs=fopen($fileName,"r");
$details="";
while(($strfp = fgets($fs))!=null){
  $details=$strfp;
}

$arrCases=explode("=>GAUR<=", $details);

$len=sizeof($arrCases);

for($i=0;$i<$len;$i++)
{
  echo $i."=>";
  echo $arrCases[$i]."<br/><br/>";

  $str=$arrCases[$i];
  $str=trim($str);
  $str=str_ireplace("'", ' ', $str);
  echo $str."<br/><br/>";

  $query="INSERT INTO ".$tableName." (`case`) VALUES ('".$str."')";
  echo $query."<br/>";
  $result=mysql_query($query);  
  if(!$result)
    echo mysql_error()."<br/>";
  

}


//print_r($arrTransactionIds);

?>