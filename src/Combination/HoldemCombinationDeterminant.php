<?php

namespace Pagrom\Poker\Combination;

use Pagrom\Poker\CardsCollection;
use Pagrom\Poker\Interfaces\CombinationDeterminantInterface;
use Pagrom\Poker\Interfaces\CombinationInterface;

class HoldemCombinationDeterminant implements CombinationDeterminantInterface
{
    /**
     * @var CombinationDeterminantInterface
     */
    private $combinationDeterminant;

    /**
     * CombinationDeterminantOmaha constructor.
     */
    public function __construct()
    {
        $this->combinationDeterminant = new CombinationDeterminant;
    }

    /**
     * @param CardsCollection $tableCards
     * @param null|CardsCollection $playerCards
     * @return CombinationInterface
     */
    public function getCombination(CardsCollection $tableCards, ?CardsCollection $playerCards = null): CombinationInterface
    {
        return $this->combinationDeterminant->getCombination($tableCards, $playerCards);
    }
}