<?php
require_once 'login.php';
require_once 'sentenceSimilarityItem.php';

#find the number of sentences in each document
$docId=1;

#print_r(getNumberOfSentences($docId));
$arrOrigSentences=getNumberOfSentences($docId);
#exit();

$arrFinal= array();
#print_r($arrOrigSentences);
#For each sentence find the similarity sentences
for($i=0;$i<sizeof($arrOrigSentences);$i++)
{
	$querySimilarSentence="Select * from sentencelevelsimilarity where FirstDocId='".$docId."' and FirstSentenceId='".$arrOrigSentences[$i]."' and FirstDocId!=SecondDocId order by LDAScore";
	$resultSimilarSentence=mysql_query($querySimilarSentence);
	$rownumSimilarSentences=mysql_num_rows($resultSimilarSentence);

	for($j=0;$j<$rownumSimilarSentences;$j++)
	{
		$rowSimilarSentence=mysql_fetch_row($resultSimilarSentence);
		#echo $docId."=>".$arrOrigSentences[$i]."<br/>";
		
		$matchingDocNumberOfSentences=getNumberOfSentences($rowSimilarSentence[4]);
		//print_r($matchingDocNumberOfSentences);
		//echo "<br/>";
		$percentMatchPerSentence=1/sizeof($matchingDocNumberOfSentences);
		//echo $percentMatchPerSentence."<br/>";
		//echo "<hr/>";
		
		$firstDocId=intval($rowSimilarSentence[1]);
		$firstSentenceId=intval($rowSimilarSentence[2]);
		$secondDocId=$rowSimilarSentence[4];
		$secondSentenceId=$rowSimilarSentence[5];
		$ldaScore=floatval($rowSimilarSentence[7]);
		$cosineScore=floatval($rowSimilarSentence[8]);
		$key=$secondDocId;

		if(!array_key_exists($key,$arrFinal))
		{
			$arrFinal[$key]=array();
			$obj=new sentenceSimilarityItem($firstDocId,$firstSentenceId,$rowSimilarSentence[3],$secondDocId,$secondSentenceId,$rowSimilarSentence[6],$ldaScore,$cosineScore,$percentMatchPerSentence);
			array_push($arrFinal[$key], $obj);
			//array_push($arrFinal[$rowSimilarSentence[4]],array("docId"=>$rowSimilarSentence[4],"originalSentence"=>$rowSimilarSentence[2]));
		}
		else
		{
			$existingldaScore=floatval($arrFinal[$key][0]->ldaScore);
			$existingFirstSentenceId=intval($arrFinal[$key][0]->firstSentenceId);
			echo "existing".$existingFirstSentenceId."=>".$firstSentenceId."=>".$secondDocId."=>".$rowSimilarSentence[7]."<br/>";
			
			if($existingldaScore>$ldaScore && $existingFirstSentenceId==$firstSentenceId)
			{
				
				// $obj=new sentenceSimilarityItem($rowSimilarSentence[1],$rowSimilarSentence[2],$rowSimilarSentence[3],$rowSimilarSentence[4],$rowSimilarSentence[5],$rowSimilarSentence[6],$rowSimilarSentence[7],$rowSimilarSentence[8],$percentMatchPerSentence);
				
				$obj=new sentenceSimilarityItem($firstDocId,$firstSentenceId,$rowSimilarSentence[3],$secondDocId,$secondSentenceId,$rowSimilarSentence[6],$ldaScore,$cosineScore,$percentMatchPerSentence);
				//array_push($arrFinal[$rowSimilarSentence[4]],array("docId"=>$rowSimilarSentence[4],"originalSentence"=>$rowSimilarSentence[2]));
				$arrFinal[$key]=$obj;
			}
			else
			{
				//$obj=new sentenceSimilarityItem($rowSimilarSentence[1],$rowSimilarSentence[2],$rowSimilarSentence[3],$rowSimilarSentence[4],$rowSimilarSentence[5],$rowSimilarSentence[6],$rowSimilarSentence[7],$rowSimilarSentence[8],$percentMatchPerSentence);
				$obj=new sentenceSimilarityItem($firstDocId,$firstSentenceId,$rowSimilarSentence[3],$secondDocId,$secondSentenceId,$rowSimilarSentence[6],$ldaScore,$cosineScore,$percentMatchPerSentence);

				//array_push($arrFinal[$rowSimilarSentence[4]],array("docId"=>$rowSimilarSentence[4],"originalSentence"=>$rowSimilarSentence[2]));
				array_push($arrFinal[$key],$obj);
			}
		}

	}

}


echo "<hr/>";
print_r($arrFinal);

exit();
#function to displlay the relvance
foreach($arrFinal as $key=>$value)
{
	$len=sizeof($value);
	if($len>1)
	{

		//$secondDocId=
		//in this case more than one sentence is mathcing the sentences of the other document
		$total=0;
		foreach ($value as $key1 => $value1) {
			echo "multiple"."=>". $value[0]->ldaScore."=>".$value[0]->cosineScore."<br/>";
			$total+=$value[0]->percentMatchPerSentence;
		}
		echo $total ."<br/>";
	}
	else
	{

		echo $value[0]->ldaScore."=>".$value[0]->cosineScore."<br/>";
	}
}



#For each matching sentence get the doc id

function getNumberOfSentences($docId)
{
	$queryOrigSentence="Select * from originalsentences Where docId='".$docId."'";
	$resultOrigSentence=mysql_query($queryOrigSentence);
	$arrOrigSentences=array();
	$rowsOrigSentence=mysql_num_rows($resultOrigSentence);
	for($i=0;$i<$rowsOrigSentence;$i++)
	{
		$row=mysql_fetch_row($resultOrigSentence);
		array_push($arrOrigSentences, $row[2]);
	}

	return $arrOrigSentences;

}



?>