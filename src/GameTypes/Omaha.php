<?php

namespace Pagrom\Poker\GameTypes;

use Pagrom\Poker\Interfaces\CombinationDeterminantInterface;
use Pagrom\Poker\Interfaces\GameTypeInterface;
use Pagrom\Poker\Combination\OmahaCombinationDeterminant;

class Omaha implements GameTypeInterface
{
    /**
    * @return int
    */
    public function getPlayerCardsCount(): int
    {
        return 4;
    }

    /**
     * @return int
     */
    public function getTableCardsCount(): int
    {
        return 5;
    }
    
    /**
     * @return CombinationDeterminantInterface
     */
    public function getCombinationDeterminant(): CombinationDeterminantInterface
    {
        return new OmahaCombinationDeterminant;
    }
}
