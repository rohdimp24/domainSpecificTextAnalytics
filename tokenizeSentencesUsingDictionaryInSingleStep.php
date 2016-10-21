<?php
require_once 'login.php';
require_once("AnalyzedCase.php");
require_once("dictionaryItem.php");

$domainName="ss";
$normalizedWordsTableName="normalizedword".$domainName;
$caseTableName="original".$domainName;
$normalizedCaseTableName="autonormalized".$domainName."_sentences";
$keymappingFile="keywordMapping_".$domainName.".csv";


$DEBUG_PRINT=0;


#################################################################################
#  READ THE LIST OF KEYWORDS, STORE THEM IN DB AND ALSO SAVE THEM IN AN ARRAY   #
#################################################################################

//read the list of the keywords
//earlier using the new_dictionary.txt which required some manual intervention. Now we will use the 
//keywordMapping.txt which has been auto generated
$fs=fopen($keymappingFile,"r");
$arrUnigramDict=array();
$arrBiTriDict=array();
while(($strfp = fgets($fs))!=null){
	if(!strlen(trim($strfp))==0)
	{
		list($sno,$variant,$canonical)=explode(",",$strfp);
		$canonical=str_replace('"', '', $canonical);
		$variant=str_replace('"', '', $variant);
		
		#split the $canonical..if it has more than 1 part then put it in diff arr
		$arrCan=explode(" ",$canonical);
		#print_r($arrCan);
		if(sizeof($arrCan)>1)
		{
			#$canonical=str_replace(" ", "_", $canonical);
			$obj=new dictionaryItem(strtolower($variant),strtolower($canonical));
			array_push($arrBiTriDict,$obj);
		}
		else
		{
			$obj=new dictionaryItem(strtolower($variant),strtolower($canonical));
			array_push($arrUnigramDict,$obj);
		}
		
		$canonical=str_replace(" ", "_", trim($canonical));
		/*$query="INSERT INTO ".$normalizedWordsTableName."(`word`) VALUES ('".trim($canonical)."') ";
		//echo $query."<br/>";
		$result=mysql_query($query);
		if(!$result)
		{
			//echo mysql_error()."<br/>";
		}
		*/
		

	}
}

fclose($fs);

#exit();
#print_r($arrBiTriDict);

#exit();

function my_in_array($entry,$arr)
{
	
	$len=sizeof($arr);
	foreach ($arr as $item) {
		if($item->variant==$entry)
			return trim($item->canonical);
	}
	return null;
}

function my_in_NgramArray($entry,$arr)
{
	
	$len=sizeof($arr);

	#echo $len."entry is ".$entry."<br/>";
	$entry=trim($entry);
	#$entry=trim($entry);
	// if(in_array($entry, $arr))
	// 	return $entry;

	foreach ($arr as $item) {
		//echo $item."<br/>";
		// if($item->canonical==$entry)
		// 	return trim($item->canonical);
		
		#echo "<br/>";

		## need to compare with the right hand as well as left hand reason being the 
		##unigram step would have converted most of the words to unigram. So the variant will be still checking for the non-unigrams. The canonical will check for the unigram converted words

		if(trim($item->variant)==$entry)
			return trim($item->canonical);
		if(trim($item->canonical)==$entry)
			return trim($item->canonical);

	}
	return null;
}



function ContainsNumbers($String){
	$tt=preg_match('/\\d/', $String) > 0;
	// if($tt)
	// 	echo "number found..";
	// else
	// 	echo "no number found..";
	return $tt;
}


function getNormalizedWord($tempword,$arrBiTriDict)
{
	$retWord=my_in_NgramArray($tempword,$arrBiTriDict);
	//echo "retword".$retWord."<br/>";

	if($retWord)
	{
		//echo "trigram added";
		//$str.=$firstword."_".$secondword."_".$thirdword." ";
		$retWord=str_replace(" ", "_", $retWord)." ";
		
		#return $retword;
	}

	return $retWord;

}


##############################
# READ THE CASES FROM THE DB #
##############################

#$fp=fopen("crmcases.txt","r");
$count=0;

$arrCases=array();
$arrUnigramFiltered=array();
$arrBigramFiltered=array();
$arrTrigramFiltered=array();

$queryCases="Select sentence from originalsentences";
#$queryCases="Select sno,caseTitle from predixstackoverflow";

echo $queryCases."<br/>";
$resultCases=mysql_query($queryCases);
$rowsnumCases=mysql_num_rows($resultCases);

#$rowsnumCases=50;

for($ii=0;$ii<$rowsnumCases;$ii++)
{
	$caseRow=mysql_fetch_row($resultCases);
	$details=$caseRow[0];
	array_push($arrCases,$details);
}


#print_r($arrCases);

$arrLen=sizeof($arrCases);
#$arrLen=20;

#check for the unigrams

for($count=0;$count<$arrLen;$count++){
	
	#echo "loop#".$i."<br/>";

	$details=$arrCases[$count];
	echo $details."<br/>";
	//$details="Bearing Metal Temp - Generator B has been decreasing and flatlining to 0degF before returning to the estimate";

	//echo $details."<br/>";		
	#if(strlen($details)<5)
		#continue;
	#else
	#{

		echo $count."=>"."<b>Original=></b>".$details."<br/>";
		$originalDescription=$details;
		//this will remove any text which has a digit and alhpabets
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
	    $details=preg_replace("/[^a-zA-Z0-9]/",' ',$details);

	    echo "<b>Cleanup (after removing puctuations)=></b>".$details."<br/>";		   

		$arrTempTerms=explode(" ",$details);
		$lenCase=sizeof($arrTempTerms);
		$str='';
		
		$lenCase=sizeof($arrTempTerms);
		$str='';
		for($i=0;$i<$lenCase;$i++)
		{
			$largestStringFound='';
			
			$firstword=strtolower($arrTempTerms[$i]);
			
			$tempword=trim($firstword);
			
			//echo $tempword."<br/>";
			//echo "<br/>unigram=>".$tempword."<br/>";
			$retWord=my_in_array($tempword,$arrUnigramDict);
			if($retWord)
			{
				//echo "<br/>the largest".$largestStringFound;
				$str.=$retWord." ";
				//$i=$i+1;
				if($DEBUG_PRINT)
					echo "uni=>".$tempword."=>".$retWord."=>".$i."<br/>";
				continue;
			}
			else
			{
				//echo $i."<br/>";
				if(strlen($tempword)>=1)
					$str.=$tempword." ";
			}
		}



		#echo "<b>Converted to =></b>".$str."<br/>-------------------------------------<br/>";
		array_push($arrUnigramFiltered, $str);
		
	#}
	
}

#print_r($arrUnigramFiltered);

#exit();

#now the trigrams
for($count=0;$count<$arrLen;$count++)
{
	$details=$arrUnigramFiltered[$count];
	// $details="on bearing metal temperature was deg when the bearing metal temperature predicted it would be deg";
	$arrTempTerms=explode(" ",$details);
	$lenCase=sizeof($arrTempTerms);
	$str='';
	echo $details."<br/>";	
	$lenCase=sizeof($arrTempTerms);
	if($DEBUG_PRINT)
		echo "case length=>".$lenCase."<br/>";
	$str=$details;
	for($i=0;$i<$lenCase;)
	{
		$largestStringFound='';
		$firstword='';
		$secondword='';
		$thirdword='';

		$firstword=strtolower($arrTempTerms[$i]);
		if($i<=($lenCase-3))
		{
			$secondword=strtolower($arrTempTerms[$i+1]);
			$thirdword=strtolower($arrTempTerms[$i+2]);
		}
				
		//echo "<br/>inside trigram=>".$tempword;
		if($firstword==" "||$secondword==" "||$thirdword==" ")
		{
			$i=$i+1;
			continue;
		}


		$tempword=trim($firstword." ".$secondword." ".$thirdword);
		if($DEBUG_PRINT)
			echo "tempword=>".$tempword."<br/>";

		$retword=getNormalizedWord($tempword,$arrBiTriDict);
		if($retword)
		{
			#echo "inside trigram";
			$str=str_replace($tempword, $retword, $str);
			if($DEBUG_PRINT)
				echo "trigram=>".$tempword."=>".$retWord."=>".$i."<br/>";
		}
		#$i=$i+3;
		//if(in_array($tempword,$arrfinal))
		
		
		$i=$i+1;
		
	}
		#echo "After trigram=>".$str."<br/>";
		array_push($arrTrigramFiltered, $str);
}


#print_r($arrTrigramFiltered);

#exit();


#now the bigrams
for($count=0;$count<$arrLen;$count++)
{
	$details=$arrTrigramFiltered[$count];
	// $details="on bearing metal temperature was deg when the bearing metal temperature predicted it would be deg";
	$arrTempTerms=explode(" ",$details);
	$lenCase=sizeof($arrTempTerms);
	$str='';
	#echo $details."<br/>";	
	$lenCase=sizeof($arrTempTerms);
	if($DEBUG_PRINT)
		echo "case length=>".$lenCase."<br/>";
	$str=$details;
	for($i=0;$i<$lenCase;)
	{
		$largestStringFound='';
		$firstword='';
		$secondword='';
		$thirdword='';

		$firstword=strtolower($arrTempTerms[$i]);
		if($i<=($lenCase-2))
		{
			$secondword=strtolower($arrTempTerms[$i+1]);
		}
				
		//echo "<br/>inside trigram=>".$tempword;
		if($firstword==" "||$secondword==" ")
		{
			$i=$i+1;
			continue;
		}
		$tempword=trim($firstword." ".$secondword);
		if($DEBUG_PRINT)
			echo "tempword=>".$tempword."<br/>";

		#$i=$i+3;
		//if(in_array($tempword,$arrfinal))
		$retWord=my_in_NgramArray($tempword,$arrBiTriDict);
		//echo "retword".$retWord."<br/>";

		if($retWord)
		{
			#echo "bigram added";
			//$str.=$firstword."_".$secondword."_".$thirdword." ";
			$retword=str_replace(" ", "_", $retWord)." ";
			#if($DEBUG_PRINT)
			#echo "bi=>".$tempword."=>".$retWord."=>". $i."<br/>"; 
			$str=str_replace($tempword, $retword, $str);
			if($DEBUG_PRINT)
				echo "bigram=>".$tempword."=>".$retWord."=>".$i."<br/>";
			#continue;
			//$largestStringFound=$retWord;
			//echo "<br/>the largest".$largestStringFound;
		}
		
		$i=$i+1;
		
	}
		#echo "After bigram=>".$str."<br/>";
		array_push($arrBigramFiltered, $str);
}


for($i=0;$i<$arrLen;$i++)
{
	echo "original=>".$arrCases[$i]."<br/>";
	echo "converted=>".$arrBigramFiltered[$i]."<br/>";
	echo "-----------------------------------<br/>";

	//if(strlen($arrCases[$i])<10)
	//	continue;
	#insert into DB
	$query="INSERT INTO ".$normalizedCaseTableName." (`original`, `normalized`) VALUES ('".$arrCases[$i]."','".$arrBigramFiltered[$i]."')";
	$result=mysql_query($query);
	if($result)
	{
		echo "<b>".mysql_error()."</b><br/>";
	}



}

#print_r($arrBigramFiltered);





//fclose($fp);
?>