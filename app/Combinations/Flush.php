<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Combinations;

/**
 * Description of Flush
 *
 * @author m1x
 */
class Flush extends CombinationAbstract
{
    public $combinationWeight = 6;
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
        $this->totalWeight = $this->combinationWeight + ($this->cards[4]->priority / 100) + ($this->cards[3]->priority / 10000) + ($this->cards[2]->priority / 1000000) + ($this->cards[1]->priority / 100000000) + ($this->cards[0]->priority / 10000000000);
    }
    
    public function getCard($number)
    {
        return $this->cards[$number];
    }
    
    protected function generateName()
    {
        $this->name =  "Flush of {$this->cards[0]->getNamedSuit()}s";
    }
}
