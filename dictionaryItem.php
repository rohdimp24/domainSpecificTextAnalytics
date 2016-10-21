<?php
class dictionaryItem
{
    public $variant;
    public $canonical;
    
    public function __construct($variant,$canonical)
    {
        $this->variant=$variant;
        $this->canonical=$canonical;
        

    }

   
}
