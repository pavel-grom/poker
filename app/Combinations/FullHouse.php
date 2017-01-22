<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Combinations;

/**
 * Description of FullHouse
 *
 * @author m1x
 */
class FullHouse extends CombinationAbstract
{
    public $combinationWeight = 7;
    public $totalWeight;
    
    public function __construct($cards) 
    {
        parent::__construct($cards);
        $this->getTotalWeightOfCombination();
        if (strlen($this->totalWeight) % 2 == 1) {
            $this->totalWeight .= '0';
        }
    }
    
    public function getTotalWeightOfCombination()
    {
        $this->totalWeight = $this->combinationWeight + ($this->cards[4]->priority / 100) + ($this->cards[0]->priority / 10000);
    }
    
    protected function generateName()
    {
        $this->name =  "FullHouse of {$this->cards[4]->getNamedPriority()} and {$this->cards[0]->getNamedPriority()}";
    }
}
