<?php
class AnalyzedCase
{
    public $sno;
    public $originalCase;
    public $tokenizedCase;
    
    public function __construct($sno,$originalCase,$tokenizedCase)
    {
        $this->sno=$sno;
        $this->originalCase=$originalCase;
        $this->tokenizedCase=$tokenizedCase;

    }

   
}
