<?php

namespace Pagrom\Poker\Combination;


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