<?php

namespace Pagrom\Poker\Combination;

use Pagrom\Poker\CardsCollection;
use Pagrom\Poker\Interfaces\CombinationDeterminantInterface;
use Pagrom\Poker\Interfaces\CombinationInterface;

class CombinationDeterminantHoldem implements CombinationDeterminantInterface{
	/**
     * CombinationDeterminantOmaha constructor.
     * @param CardsCollection $tableCards
     * @param CardsCollection $playerCards Optional.
     */
    public function __construct(CardsCollection $tableCards, ?CardsCollection $playerCards = null)
    {
		
        $this->combination = (new CombinationDeterminant($tableCards, $playerCards))->getCombination();
    }
	
}