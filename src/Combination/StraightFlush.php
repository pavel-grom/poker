<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 13:07
 */

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