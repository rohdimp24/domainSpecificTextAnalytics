<?php
require_once 'login.php';

$fp=fopen("incident.incident.csv","r");
$count=0;

while(($details = fgets($fp))!=null){
	if($count==0)
	{
		$count=$count+1;
		continue;
	}
	$count=$count+1;

	if($count==5000)
		break;
	$details=trim($details);
	$details=str_replace('"', '', $details);
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







	if(strlen($details)<5)
		continue;
	$query="INSERT INTO originalincidents (`incident`) VALUES ('".$details."')";
	//echo $query."<br/>";
	$result=mysql_query($query);	
	if(!$result)
		echo mysql_error()."<br/>";
	//echo $result;
	//break;
	
}

fclose($fp);
?>