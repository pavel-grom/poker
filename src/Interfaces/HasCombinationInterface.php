<?php

namespace Pagrom\Poker\Interfaces;


interface HasCombinationInterface
{
    /**
     * @param CombinationInterface $combination
     */
    public function setCombination(CombinationInterface $combination): void;

    /**
     * @return CombinationInterface|null
     */
    public function getCombination(): ?CombinationInterface;
}