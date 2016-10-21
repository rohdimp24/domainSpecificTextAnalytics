<?php 
require_once 'login.php';

//read the list of the keywords
$fs=fopen("stopwords.txt","r");
$arrfinal=array();
while(($strfp = fgets($fs))!=null){
	if(!strlen(trim($strfp))==0)
	{
		
		$strfp=str_ireplace("\"", ' ', $strfp);
		$stopwords=explode(",", $strfp);
		//print_r($stopwords);
		$len=sizeof($stopwords);
		for($i=0;$i<$len;$i++)
		{
			$query="INSERT INTO `stopwords`(`stopword`) VALUES ('".trim($stopwords[$i])."') ";
			$result=mysql_query($query);
			if(!$result)
			{
				echo $stopwords[$i]."...";
				echo mysql_error()."<br/>";
			}
		}

		
	}

	
}





 ?>