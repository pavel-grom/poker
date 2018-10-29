<?php

namespace Pagrom\Poker\Combination;


use Pagrom\Poker\Interfaces\SuitOrientedCombinationInterface;

class Flush extends CombinationAbstract implements SuitOrientedCombinationInterface
{
    /**
     * @const int WEIGHT
     * */
    public const WEIGHT = 6;

    /**
     * @return int
     */
    public function getTotalWeight(): int
    {
        $totalWeight = self::WEIGHT;

        foreach ($this->cards->sortByPriority(true) as $card) {
            $totalWeight .= $card->getWeight();
        }

        return (int) $totalWeight;
    }

    /**
     * @return int
     */
    public function getSuit(): int
    {
        return $this->cards[0]->getSuit();
    }
}