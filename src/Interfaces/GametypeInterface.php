<?php

namespace Pagrom\Poker\Interfaces;
use \Pagrom\Poker\CardsCollection;

interface GametypeInterface
{
    /**
     * @return int
     */
    public function getCardcountPlayer(): int;

    /**
     * @return int
     */
    public function getCardcountTable():int;
    
    /**
     * @return CombiationDeterminant
     */
    public function getCombinationDeterminant(CardsCollection $tableCards, ?CardsCollection $playerCards = null);
    
    
}