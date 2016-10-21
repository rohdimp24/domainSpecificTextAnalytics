<?php 
require_once 'login.php';

$domainName="ss";
$tableName="normalizedword".$domainName;
//read the list of the keywords
//earlier using the new_dictionary.txt which required some manual intervention. Now we will use the 
//keywordMapping.txt which has been auto generated
$fs=fopen("keywordMapping_ss.csv","r");
while(($strfp = fgets($fs))!=null){
	if(!strlen(trim($strfp))==0)
		{
			list($sno,$variant,$canonical)=explode(",",$strfp);
			$canonical=str_replace(" ", "_", $canonical);
			$canonical=str_replace('"', '', $canonical);
			$query="INSERT INTO ".$tableName."(`word`) VALUES ('".trim($canonical)."') ";
			$result=mysql_query($query);
			if(!$result)
			{
				echo mysql_error()."<br/>";
			}
		}
}

fclose($fs);
 ?>