<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 13:01
 */

namespace App\Combination;


use App\Card;
use App\Interfaces\HasTwoKickersInterface;
use App\Interfaces\OnePriorityOrientedCombinationInterface;

class HighCard extends CombinationAbstract implements HasTwoKickersInterface, OnePriorityOrientedCombinationInterface
{
    /**
     * @const int WEIGHT
     * */
    public const WEIGHT = 1;

    /**
     * @return int
     */
    public function getTotalWeight(): int
    {
        $totalWeight = self::WEIGHT;

        foreach ($this->cards->sortByPriority(true) as $card) {
            $totalWeight .= $card->getWeight();
        }

        $missedCardsCount = 5 - $this->cards->count();

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
     * @return int
     */
    public function getPriority(): int
    {
        return $this->cards->sortByPriority(true)[0]->getPriority();
    }
}