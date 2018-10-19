<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 13:01
 */

namespace App\Combination;


class HighCard extends CombinationAbstract
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

        if ($missedCardsCount < 0) {
            for ($i = 0; $i < $missedCardsCount; $i++) {
                $totalWeight .= '00';
            }
        }

        return (int) $totalWeight;
    }
}