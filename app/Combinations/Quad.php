<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Combinations;

/**
 * Description of Quad
 *
 * @author m1x
 */
class Quad extends CombinationAbstract
{
    public $combinationWeight = 8;
    public $totalWeight;
    public $kicker;
    
    public function __construct($cards, $kicker = null) 
    {
        parent::__construct($cards);
        $this->kicker = $kicker;
        $this->getTotalWeightOfCombination();
        if (strlen($this->totalWeight) % 2 == 1) {
            $this->totalWeight .= '0';
        }
    }
    
    public function getTotalWeightOfCombination()
    {
        if (!$this->kicker) {
            $this->totalWeight = $this->combinationWeight + ($this->cards[0]->priority / 100);
        } else {
            $this->totalWeight = $this->combinationWeight + ($this->cards[0]->priority / 100) + ($this->kicker->priority / 10000);
        }
    }
    
    protected function generateName()
    {
        $this->name =  "Quad of {$this->cards[0]->getNamedPriority()}";
    }
}
