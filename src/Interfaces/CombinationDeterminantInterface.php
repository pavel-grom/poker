<?php

namespace Pagrom\Poker\Interfaces;

interface CombinationDeterminantInterface
{
    /**
     * @return CombinationInterface
     */
    public function getCombination(): CombinationInterface;
}