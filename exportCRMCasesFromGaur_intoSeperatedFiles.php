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
$case_id=1;
for($i=0;$i<$len;$i++)
{
  echo $i."=>";
  echo $arrCases[$i]."<br/><br/>";

  $str=$arrCases[$i];
  $str=trim($str);
  $details=$str;
  $details=preg_replace('/[^A-Za-z0-9 _\-\+\&\,\#]/','', $details);
  $details=trim($details);
  $details=trim($details,'"');
  $details=str_ireplace("\"", ' ', $details);
  $details=str_ireplace(">", ' ', $details);
  $details=str_ireplace("@", ' ', $details);
  $details=str_ireplace("<", ' ', $details);
  $details=str_ireplace(":", ' ', $details);
  $details=str_ireplace(".", ' ', $details);
  $details=str_ireplace("[", ' ', $details);
  $details=str_ireplace("]", ' ', $details);
  $details=str_ireplace("_", ' ', $details);
  $details=str_ireplace(",", ' ', $details);
  $details=str_ireplace("#", ' ', $details);
  $details=str_ireplace("-", ' ', $details);
  $details=str_ireplace("/", ' ', $details);
  $details=str_ireplace(".", ' ', $details);
  $details = preg_replace('/[0-9]+/', ' ', $details);


  echo $details."<br/><br/>";

  //create a file and then instert the data
  $filenames="cases\\".$case_id.".txt";
  echo $filenames;
  $fp=fopen($filenames,"w");
  fwrite($fp, $details);
  fclose($fp);

  $case_id=$case_id+1;
  

}


//print_r($arrTransactionIds);

?>