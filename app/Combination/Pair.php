<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 13:03
 */

namespace App\Combination;


class Pair extends CombinationAbstract
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
}