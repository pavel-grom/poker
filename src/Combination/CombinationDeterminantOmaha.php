<?php

namespace Pagrom\Poker\Combination;

use Pagrom\Poker\CardsCollection;
use Pagrom\Poker\Interfaces\CombinationDeterminantInterface;
use Pagrom\Poker\Interfaces\CombinationInterface;

class CombinationDeterminantOmaha implements CombinationDeterminantInterface
{
    /**
     * @var CombinationInterface
     * */
    private $combination;
    /**
     * @var CardsCollection
     */
    private $tableCards;
    /**
     * @var null|CardsCollection
     */
    private $playerCards;

    /**
     * CombinationDeterminantOmaha constructor.
     * @param CardsCollection $tableCards
     * @param CardsCollection $playerCards Optional.
     */
    public function __construct(CardsCollection $tableCards, ?CardsCollection $playerCards = null)
    {
        $this->tableCards = $tableCards;
        $this->playerCards = $playerCards;

        $this->combination = $this->determineCombination();
    }

    /**
     * @return CombinationInterface
     */
    public function getCombination(): CombinationInterface
    {
        return $this->combination;
    }

    /**
     * @return CombinationInterface
     */
    private function determineCombination(): CombinationInterface
    {
        $maxWeight = 0;
        $maxCombination = null;

        foreach ($this->tableCards->getMathCombinationsCards(3) as $tableCardsCombination) {
            foreach ($this->playerCards->getMathCombinationsCards(2)as $playerCardsCombination) {
                $combination = (new CombinationDeterminant($tableCardsCombination, $playerCardsCombination))->getCombination();
                if ($combination->getTotalWeight() > $maxWeight){
                    $maxWeight = $combination->getTotalWeight();
                    $maxCombination = $combination;
                }
            }
        }

        return $maxCombination;
    }
}