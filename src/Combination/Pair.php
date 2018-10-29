<?php

namespace Pagrom\Poker\Combination;


use Pagrom\Poker\Card;
use Pagrom\Poker\CardsCollection;
use Pagrom\Poker\Interfaces\HasTwoKickersInterface;
use Pagrom\Poker\Interfaces\OnePriorityOrientedCombinationInterface;

class Pair extends CombinationAbstract implements HasTwoKickersInterface, OnePriorityOrientedCombinationInterface
{
    /**
     * @const int WEIGHT
     * */
    public const WEIGHT = 2;

    /**
     * @return int
     */
    public function getTotalWeight(): int
    {
        $totalWeight = self::WEIGHT;

        $totalWeight .= $this->onlyCombinationCards->random()->getWeight();

        foreach ($this->onlyNotCombinationCards->sortByPriority(true) as $card) {
            $totalWeight .= $card->getWeight();
        }

        $missedCardsCount = 5 - $this->onlyNotCombinationCards->count() - 1;

        for ($i = 0; $i < $missedCardsCount; $i++) {
            $totalWeight .= '00';
        }

        return (int) $totalWeight;
    }

    /**
     * @return Card|null
     */
    public function getKicker(): ?Card
    {
        return $this->playerOnlyNotCombinationCards->sortByPriority(true)[0] ?? null;
    }

    /**
     * @return Card|null
     */
    public function getSecondKicker(): ?Card
    {
        return $this->playerOnlyNotCombinationCards->sortByPriority(true)[1] ?? null;
    }

    /**
     * @return CardsCollection
     */
    public function getSortedCards(): CardsCollection
    {
        return $this->onlyCombinationCards->merge($this->onlyNotCombinationCards->sortByPriority(true));
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->onlyCombinationCards[0]->getPriority();
    }
}