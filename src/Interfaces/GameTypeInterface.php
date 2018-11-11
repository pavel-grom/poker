<?php

namespace Pagrom\Poker\Interfaces;

interface GameTypeInterface
{
    /**
     * @return int
     */
    public function getPlayerCardsCount(): int;

    /**
     * @return int
     */
    public function getTableCardsCount(): int;

    /**
     * @return CombinationDeterminantInterface
     */
    public function getCombinationDeterminant(): CombinationDeterminantInterface;
}