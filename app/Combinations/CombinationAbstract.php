<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Combinations;

/**
 *
 * @author m1x
 */
abstract class CombinationAbstract
{
    public $cards;
    public $name;
    public $totalWeight;
    public $kicker = null;
    public $secondKicker = null;
    
    public function __construct($cards) 
    {
        $this->cards = $cards;
        $this->generateName();
    }
    
    abstract public function getTotalWeightOfCombination();
    abstract protected function generateName();
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getKicker()
    {
        if ($this->kicker !== null) {
            return $this->kicker->getName();
        }
        return null;
    }
    
    public function getSecondKicker()
    {
        if ($this->secondKicker !== null) {
            return $this->secondKicker->getName();
        }
        return null;
    }
    
    public function cardExists($card)
    {
        foreach ($this->cards as $combCard) {
            if ($card->priority == $combCard->priority && $card->suit == $combCard->suit) {
                return true;
            }
        }
        if ($this->kicker) {
            if ($card->priority == $this->kicker->priority && $card->suit == $this->kicker->suit) {
                return true;
            }
        }
        if ($this->secondKicker) {
            if ($card->priority == $this->secondKicker->priority && $card->suit == $this->secondKicker->suit) {
                return true;
            }
        }
        return false;
    }
}
