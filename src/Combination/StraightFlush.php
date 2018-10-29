<?php

namespace Pagrom\Poker\Combination;


use Pagrom\Poker\Interfaces\SuitOrientedCombinationInterface;

class StraightFlush extends Straight implements SuitOrientedCombinationInterface
{
    /**
     * @const int WEIGHT
     * */
    public const WEIGHT = 9;

    /**
     * @return int
     */
    public function getSuit(): int
    {
        return $this->onlyCombinationCards[0]->getSuit();
    }
}