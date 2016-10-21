<?php
class SimilarDocument
{
    public $docNum;
    public $score;
    
    public function __construct($docNum,$similarityScore)
    {
        $this->docNum=$docNum;
        $this->score=$similarityScore;
    }
}
