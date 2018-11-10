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
		$maxweight=0;
		$max_tablecards = new CardsCollection();
		$max_playercards = new CardsCollection();
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
				
				if($this->combination->getTotalWeight()>$maxweight){
					$max_tablecards = clone $this->tableCards;
					$max_playercards = clone $this->playerCards;
					$maxweight = $this->combination->getTotalWeight();
					
				}
				
			}
		}
		$this->pairs = [];
		$this->quads = [];
		$this->sets = [];
		$this->tableCards = $max_tablecards;
		$this->playerCards = $max_playercards;
		$this->cards = $max_tablecards->merge($this->playerCards)->sortByPriority();
				
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