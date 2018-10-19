<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 13:04
 */

namespace App\Combination;


class FullHouse extends CombinationAbstract
{
    /**
     * @const int WEIGHT
     * */
    public const WEIGHT = 7;

    /**
     * @return int
     */
    public function getTotalWeight(): int
    {
        $totalWeight = self::WEIGHT;

        $onlyCombinationCards = $this->cards->sortByPriority();

        $pairPriority = $onlyCombinationCards[0]->getWeight();
        $setPriority = $onlyCombinationCards[$onlyCombinationCards->count() - 1]->getWeight();

        $totalWeight .= $setPriority . $pairPriority;

        $totalWeight .= '000000';

        return (int) $totalWeight;
    }
}