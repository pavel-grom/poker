<?php

namespace Pagrom\Poker\FakeCombinations;


use Pagrom\Poker\CardsCollection;
use Pagrom\Poker\Combination\Pair;
use Pagrom\Poker\Combination\Set;

class TwoSets
{
    /**
     * @var Set
     */
    private $smallerSet;

    /**
     * @var Set
     */
    private $biggerSet;
    /**
     * @var CardsCollection
     */
    private $playerCards;

    /**
     * @var Pair
     */
    private $pair;

    /**
     * TwoSets constructor.
     * @param Set $smallerSet
     * @param Set $biggerSet
     * @param CardsCollection $playerCards
     */
    public function __construct(Set $smallerSet, Set $biggerSet, CardsCollection $playerCards)
    {
        $this->smallerSet = $smallerSet;
        $this->biggerSet = $biggerSet;
        $this->playerCards = $playerCards;

        $smallerSetCards = $smallerSet->getOnlyCombinationCards();
        $smallerSetCards->removeRandomCard();

        $this->pair = new Pair($smallerSetCards, $playerCards);
    }

    /**
     * @return CardsCollection
     */
    public function getFullHouseCards(): CardsCollection
    {
        return $this->biggerSet->getOnlyCombinationCards()->merge($this->pair->getOnlyCombinationCards());
    }
}