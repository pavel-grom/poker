<?php

namespace Pagrom\Poker\Interfaces;

use Pagrom\Poker\CardsCollection;

interface CombinationDeterminantInterface
{
    /**
     * @param CardsCollection $tableCards
     * @param null|CardsCollection $playerCards
     * @return CombinationInterface
     */
    public function getCombination(CardsCollection $tableCards, ?CardsCollection $playerCards = null): CombinationInterface;
}