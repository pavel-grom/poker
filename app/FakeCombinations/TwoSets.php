<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 13:03
 */

namespace App\FakeCombinations;


use App\CardsCollection;
use App\Combination\Pair;
use App\Combination\Set;

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