<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 13:07
 */

namespace Pagrom\Poker\Combination;


use Pagrom\Poker\Interfaces\OnePriorityOrientedCombinationInterface;
use Pagrom\Poker\Interfaces\SuitOrientedCombinationInterface;

class RoyalFlush extends CombinationAbstract implements OnePriorityOrientedCombinationInterface, SuitOrientedCombinationInterface
{
    /**
     * @const int WEIGHT
     * */
    public const WEIGHT = 10;

    /**
     * @return int
     */
    public function getTotalWeight(): int
    {
        $totalWeight = self::WEIGHT;

        $totalWeight .= '0000000000';

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
    public function getSuit(): int
    {
        return $this->onlyCombinationCards[0]->getSuit();
    }
}