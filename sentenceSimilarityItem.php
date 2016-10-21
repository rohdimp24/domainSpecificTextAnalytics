<?php
class sentenceSimilarityItem
{
    public $firstDocId;
    public $firstSentenceId;
    public $firstToken;
    public $secondDocId;
    public $secondSentenceId;
    public $secondToken;
    public $ldaScore;
    public $cosineScore;
    public $percentageRelevance;
    
    
    public function __construct($firstDocId,$firstSentenceId,$firstToken,$secondDocId,$secondSentenceId,
    	$secondToken,$ldaScore,$cosineScore,$percentageRelevance)
    {
        $this->firstDocId=$firstDocId;
        $this->firstSentenceId=$firstSentenceId;
        $this->firstToken=$firstToken;
        $this->secondDocId=$secondDocId;
        $this->secondSentenceId=$secondSentenceId;
        $this->secondToken=$secondToken;
        $this->ldaScore=$ldaScore;
        $this->cosineScore=$cosineScore;
        $this->percentageRelevance=$percentageRelevance;
    }

   
}
