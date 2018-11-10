<?php

namespace Pagrom\Poker\Combination;

use Pagrom\Poker\CardsCollection;
use Pagrom\Poker\Card;


class CombinationDeterminantOmaha extends CombinationDeterminant{
    /**
     * CombinationDeterminantOmaha constructor.
     * @param CardsCollection $tableCards
     * @param CardsCollection $playerCards Optional.
     */
    public function __construct(CardsCollection $tableCards, ?CardsCollection $playerCards = null)
    {
        $maxWeight=0;
        $maxTablecards = new CardsCollection();
        $maxPlayercards = new CardsCollection();
        foreach($tableCards->getMathCombinationsCards(3) as $tableCardsCombination){
            foreach($playerCards->getMathCombinationsCards(2)as $playerCardsCombination){
                $this->pairs = [];
                $this->quads = [];
                $this->sets = [];
                $this->tableCards = $tableCardsCombination;

                $this->playerCards = $playerCardsCombination ?? new CardsCollection();
                $this->cards = $tableCardsCombination->merge($this->playerCards)->sortByPriority();
                $this->priorities = $this->cards->map(function(Card $card){
                    return $card->getPriority();
                });
                $this->suites = $this->cards->map(function(Card $card){
                    return $card->getSuit();
                });

                $this->getPrioritiesCounts();
                $this->combination = $this->determineCombination();
                
                if($this->combination->getTotalWeight()>$maxWeight){
                    $maxTablecards = clone $this->tableCards;
                    $maxPlayercards = clone $this->playerCards;
                    $maxWeight = $this->combination->getTotalWeight();
                    
                }
                
            }
        }
        $this->pairs = [];
        $this->quads = [];
        $this->sets = [];
        $this->tableCards = $maxTablecards;
        $this->playerCards = $maxPlayercards;
        $this->cards = $maxTablecards->merge($this->playerCards)->sortByPriority();
                
        $this->priorities = $this->cards->map(function(Card $card){
            return $card->getPriority();
        });
        $this->suites = $this->cards->map(function(Card $card){
            return $card->getSuit();
        });

        $this->getPrioritiesCounts();

        $this->combination = $this->determineCombination();
    }
}