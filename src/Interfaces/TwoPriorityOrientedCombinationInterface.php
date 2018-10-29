<?php

namespace Pagrom\Poker\Interfaces;


interface TwoPriorityOrientedCombinationInterface extends OnePriorityOrientedCombinationInterface
{
    /**
     * @return int
     */
    public function getSecondPriority(): int;
}