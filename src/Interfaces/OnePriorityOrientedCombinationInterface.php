<?php

namespace Pagrom\Poker\Interfaces;


interface OnePriorityOrientedCombinationInterface
{
    /**
     * @return int
     */
    public function getPriority(): int;
}