<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 020 20.10.18
 * Time: 16:42
 */

namespace Pagrom\Poker\Interfaces;


interface TwoPriorityOrientedCombinationInterface extends OnePriorityOrientedCombinationInterface
{
    /**
     * @return int
     */
    public function getSecondPriority(): int;
}