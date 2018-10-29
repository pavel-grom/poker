<?php

namespace Pagrom\Poker\Interfaces;


interface SuitOrientedCombinationInterface
{
    /**
     * @return int
     */
    public function getSuit(): int;
}