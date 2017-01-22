<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Combinations;

/**
 * Description of RoyalFlush
 *
 * @author m1x
 */
class RoyalFlush extends CombinationAbstract
{
    public $combinationWeight = 10;
    public $totalWeight;
    
    public function __construct($cards) 
    {
        parent::__construct($cards);
        $this->getTotalWeightOfCombination();
    }
    
    public function getTotalWeightOfCombination()
    {
        $this->totalWeight = 10;
    }
    
    protected function generateName()
    {
        $this->name =  "Royal Flush";
    }
}
