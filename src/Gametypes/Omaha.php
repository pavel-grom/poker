<?php

namespace Pagrom\Poker\Gametypes;

use Pagrom\Poker\Interfaces\GametypeInterface;
use Pagrom\Poker\Combination\CombinationDeterminantOmaha;
use \Pagrom\Poker\CardsCollection;


class Omaha implements GametypeInterface{
    /**
     * @return int
     */
     public function getCardcountPlayer():int{
        return 4;
    }

    /**
     * @return int
     */
    public function getCardcountTable():int{
        return 5;
    }
    
    /**
     * @param CardsCollection $tableCards
     * @param CardsCollection $playerCards
     * @return CombinationDeterminantOmaha
     */
    public function getCombinationDeterminant(CardsCollection $tableCards, ?CardsCollection $playerCards = null){
        return new CombinationDeterminantOmaha($tableCards,$playerCards);
    }
}
