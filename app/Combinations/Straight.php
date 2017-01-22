<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Combinations;

/**
 * Description of Straight
 *
 * @author m1x
 */
class Straight extends CombinationAbstract
{
    public $combinationWeight = 5;
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
        $this->totalWeight = $this->combinationWeight + ($this->cards[4]->priority / 100);
    }
    
    public function getHighCard()
    {
        return $this->cards[4];
    }
    
    protected function generateName()
    {
        $this->name =  "Straight to {$this->cards[4]->getNamedPriority()}";
    }
}
