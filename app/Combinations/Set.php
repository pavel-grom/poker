<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Combinations;

/**
 * Description of Set
 *
 * @author m1x
 */
class Set extends CombinationAbstract
{
    public $combinationWeight = 4;
    public $totalWeight;
    public $kicker;
    public $secondKicker;
    
    public function __construct($cards, $kicker = null, $secondKicker = null) 
    {
        parent::__construct($cards);
        $this->kicker = $kicker;
        $this->secondKicker = $secondKicker;
        $this->getTotalWeightOfCombination();
        if (strlen($this->totalWeight) % 2 == 1) {
            $this->totalWeight .= '0';
        }
    }
    
    public function getTotalWeightOfCombination()
    {
        if (!$this->kicker && !$this->secondKicker) {
            $this->totalWeight = $this->combinationWeight + ($this->cards[0]->priority / 100);
        } elseif (!$this->secondKicker) {
            $this->totalWeight = $this->combinationWeight + ($this->cards[0]->priority / 100) + ($this->kicker->priority / 10000);
        } else {
            $this->totalWeight = $this->combinationWeight + ($this->cards[0]->priority / 100) + ($this->kicker->priority / 10000) + ($this->secondKicker->priority / 1000000);
        }
    }
    
    protected function generateName()
    {
        $this->name =  "Set of {$this->cards[0]->getNamedPriority()}";
    }
}
