<?php

namespace Pagrom\Poker\Gametypes;

use Pagrom\Poker\Interfaces\GametypeInterface;
use Pagrom\Poker\Combination\CombinationDeterminantHoldem;
use \Pagrom\Poker\CardsCollection;


class Holdem implements GametypeInterface{
    /**
     * @return int
     */
     public function getCardcountPlayer():int{
        return 2;
    }

    /**
     * @return int
     */
    public function getCardcountTable():int{
        return 5;
    }
    
    /**
     * @param CardsCollection $tableCards
     * @param CardsCollection $playerCards Optional.
     * @return CombinationDeterminantHoldem
     */
    public function getCombinationDeterminant(CardsCollection $tableCards, ?CardsCollection $playerCards = null){
        return new CombinationDeterminantHoldem($tableCards,$playerCards);
    }
}
