<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Combinations;

/**
 * Description of HighCard
 *
 * @author m1x
 */
class HighCard extends CombinationAbstract
{
    public $combinationWeight = 1;
    public $highCard;
    
    public function __construct($highCard, $kicker, $secondKicker = null, $cards) 
    {
        $this->highCard = $highCard;
        $this->kicker = $kicker;
        $this->secondKicker = $secondKicker;
        $this->getTotalWeightOfCombination();
        if (strlen($this->totalWeight) % 2 == 1) {
            $this->totalWeight .= '0';
        }
        parent::__construct($cards);
    }


    public function getTotalWeightOfCombination()
    {
        if (!$this->secondKicker) {
            $this->totalWeight = $this->combinationWeight + ($this->highCard->priority / 100) + ($this->kicker->priority / 10000);
        } else {
            $this->totalWeight = $this->combinationWeight + ($this->highCard->priority / 100) + ($this->kicker->priority / 10000) + ($this->secondKicker->priority / 1000000);
        }
    }
    
    public function getHighCard()
    {
        return $this->highCard;
    }
    
    protected function generateName()
    {
        $this->name =  "High card - {$this->highCard->getName()}";
    }
}
