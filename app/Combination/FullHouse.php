<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 13:04
 */

namespace App\Combination;


use App\Interfaces\TwoPriorityOrientedCombinationInterface;

class FullHouse extends CombinationAbstract implements TwoPriorityOrientedCombinationInterface
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

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->onlyCombinationCards->sortByPriority(true)[0]->getPriority();
    }

    /**
     * @return int
     */
    public function getSecondPriority(): int
    {
        return $this->onlyCombinationCards->sortByPriority()[0]->getPriority();
    }
}