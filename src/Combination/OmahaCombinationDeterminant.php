<?php

namespace Pagrom\Poker\Combination;

use Pagrom\Poker\CardsCollection;
use Pagrom\Poker\Interfaces\CombinationDeterminantInterface;
use Pagrom\Poker\Interfaces\CombinationInterface;

class OmahaCombinationDeterminant implements CombinationDeterminantInterface
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
        $maxWeight = 0;
        $maxCombination = null;

        foreach ($tableCards->getMathCombinationsCards(3) as $tableCardsCombination) {
            foreach ($playerCards->getMathCombinationsCards(2) as $playerCardsCombination) {
                $combination = $this->combinationDeterminant->getCombination($tableCardsCombination, $playerCardsCombination);
                $combinationTotalWeight = $combination->getTotalWeight();
                if ($combinationTotalWeight > $maxWeight) {
                    $maxWeight = $combinationTotalWeight;
                    $maxCombination = $combination;
                }
            }
        }

        return $maxCombination;
    }
}