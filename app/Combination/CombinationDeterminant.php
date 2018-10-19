<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 11:19
 */

namespace App\Combination;


use App\Card;
use App\CardsCollection;
use App\Exceptions\GameLogicException;
use App\FakeCombinations\TwoSets;
use App\Interfaces\CombinationInterface;

class CombinationDeterminant
{
    /**
     * @var CardsCollection $tableCards
     * */
    private $tableCards;

    /**
     * @var CardsCollection $playerCards
     * */
    private $playerCards;

    /**
     * @var CardsCollection $cards
     * */
    private $cards;

    /**
     * @var int[] $priorities
     * */
    private $priorities;

    /**
     * @var int[] $suites
     * */
    private $suites;

    /**
     * @var array $pairs
     * */
    private $pairs = [];

    /**
     * @var array $sets
     * */
    private $sets = [];

    /**
     * @var array $quads
     * */
    private $quads = [];

    /**
     * CombinationDeterminant constructor.
     * @param CardsCollection $tableCards
     * @param CardsCollection $playerCards
     */
    public function __construct(CardsCollection $tableCards, ?CardsCollection $playerCards = null)
    {
        $this->tableCards = $tableCards;

        $this->playerCards = $playerCards ?? new CardsCollection();
        $this->cards = $tableCards->merge($this->playerCards)->sortByPriority();

        $this->priorities = $this->cards->map(function(Card $card){
            return $card->getPriority();
        });

        $this->suites = $this->cards->map(function(Card $card){
            return $card->getSuit();
        });

        $this->getPrioritiesCounts();
    }

    /**
     * @return CombinationInterface
     */
    public function determineCombination(): CombinationInterface
    {
        if ($combination = $this->checkRoyalFlush()) {
            return $combination;
        } elseif ($combination = $this->checkStraightFlush()) {
            return $combination;
        } elseif ($combination = $this->checkQuad()) {
            return $combination;
        } elseif ($combination = $this->checkFullHouse()) {
            return $combination;
        } elseif ($combination = $this->checkFlush()) {
            return $combination;
        } elseif ($combination = $this->checkStraight()) {
            return $combination;
        } elseif ($combination = $this->checkSet()) {
            return $combination;
        } elseif ($combination = $this->checkTwoPairs()) {
            return $combination;
        } elseif ($combination = $this->checkPair()) {
            return $combination;
        } elseif ($combination = $this->checkHighCard()) {
            return $combination;
        }

        throw new GameLogicException('Something was wrong');
    }

    /**
     * @return HighCard
     */
    private function checkHighCard(): HighCard
    {
        $smallerCardsCount = count($this->priorities) - 5;

        if ($smallerCardsCount <= 0) {
            return new HighCard(
                $this->cards->getCardsByPriorities($this->priorities),
                $this->playerCards
            );
        }

        sort($this->priorities);

        return new HighCard(
            $this->cards->getCardsByPriorities(
                array_slice(
                    $this->priorities,
                    $smallerCardsCount,
                    5
                )
            ),
            $this->playerCards,
            $this->cards->getCardsByPriorities(max($this->priorities))
        );
    }

    /**
     * @return Pair|null
     */
    private function checkPair(): ?Pair
    {
        if (count($this->pairs) !== 1) {
            return null;
        }

        $pairPriority = $this->pairs[0];

        $combinationPriorities = [
            $pairPriority
        ];

        $priorities = array_filter($this->priorities, function(int $priority) use ($pairPriority) {
            return $priority !== $pairPriority;
        });
        rsort($priorities);

        $combinationPriorities = array_merge(
            $combinationPriorities,
            array_slice($priorities, 0, 3)
        );

        $combinationCards = $this->cards->getCardsByPriorities($combinationPriorities);
        $onlyCombinationCards = $this->cards->getCardsByPriorities($pairPriority);

        return new Pair($combinationCards, $this->playerCards, $onlyCombinationCards);
    }

    /**
     * @return TwoPairs|null
     */
    private function checkTwoPairs(): ?TwoPairs
    {
        if (count($this->pairs) !== 2) {
            return null;
        }

        $priorities = array_filter($this->priorities, function(int $priority) {
            return !in_array($priority, $this->pairs, true);
        });
        rsort($priorities);

        $combinationPriorities = $this->pairs;
        $combinationPriorities[] = $priorities[0];

        $combinationCards = $this->cards->getCardsByPriorities($combinationPriorities);
        $onlyCombinationCards = $this->cards->getCardsByPriorities($this->pairs);

        return new TwoPairs($combinationCards, $this->playerCards, $onlyCombinationCards);
    }

    /**
     * @return Set|null
     */
    private function checkSet(): ?Set
    {
        $setsCount = count($this->sets);

        if ($setsCount !== 1) {
            return null;
        }

        $priorities = array_filter($this->priorities, function(int $priority) {
            return !in_array($priority, $this->sets, true);
        });
        rsort($priorities);

        $combinationPriorities = array_merge(
            $this->sets,
            array_slice($priorities, 0, 2)
        );

        $combinationCards = $this->cards->getCardsByPriorities($combinationPriorities);
        $onlyCombinationCards = $this->cards->getCardsByPriorities(
            $this->sets[array_search(max($this->sets), $this->sets)]
        );

        return new Set($combinationCards, $this->playerCards, $onlyCombinationCards);
    }

    /**
     * @return TwoSets|null
     */
    private function checkTwoSets(): ?TwoSets
    {
        $setsCount = count($this->sets);

        if ($setsCount !== 2) {
            return null;
        }

        $smallerSetKey = array_search(min($this->sets), $this->sets);
        $smallerSetPriority = $this->sets[$smallerSetKey];

        $biggerSetKey = array_search(max($this->sets), $this->sets);
        $biggerSetPriority = $this->sets[$biggerSetKey];

        $smallerSetCards = $this->cards->getCardsByPriorities($smallerSetPriority);
        $biggerSetCards = $this->cards->getCardsByPriorities($biggerSetPriority);

        $smallerSet = new Set($smallerSetCards, $this->playerCards);
        $biggerSet = new Set($biggerSetCards, $this->playerCards);

        return new TwoSets($smallerSet, $biggerSet, $this->playerCards);
    }

    /**
     * @return Straight|null
     */
    private function checkStraight(): ?Straight
    {
        if ($this->cards->count() < 5) {
            return null;
        }

        $cards = clone $this->cards;

        foreach ($cards as $key => $card) {
            if (isset($cards[$key+1])) {
                if ($cards[$key]->getPriority() === $cards[$key+1]->getPriority()) {
                    unset($cards[$key]);
                }
            }
        }

        $cards = $cards->values();
        $count = $cards->count();

        if (
            isset($cards[$count-5])
            && $cards[$count-1]->getPriority() - $cards[$count-5]->getPriority() === 4
        ) {
            $straightCards = $cards->slice($count - 5, 5);
        } elseif (
            isset($cards[$count-6])
            && $cards[$count-2]->getPriority() - $cards[$count-6]->getPriority() === 4
        ) {
            $straightCards = $cards->slice($count - 6, 5);
        } elseif (
            isset($cards[$count-7])
            && $cards[$count-3]->getPriority() - $cards[$count-7]->getPriority() === 4
        ) {
            $straightCards = $cards->slice($count - 7, 5);
        } elseif (
            $cards[0]->getPriority() === 1
            && $cards[1]->getPriority() === 2
            && $cards[2]->getPriority() === 3
            && $cards[3]->getPriority() === 4
            && $cards[$cards->count()-1]->getPriority() === 13
        ) {
            $straightCards = (new CardsCollection([$cards[$cards->count()-1]]))
                ->merge($cards->slice(0, 4));
        }

        if (!isset($straightCards)) {
            return null;
        }

        return new Straight($straightCards, $this->playerCards);
    }

    /**
     * @return Flush|null
     */
    private function checkFlush(): ?Flush
    {
        $cards = clone $this->cards;
        $suitsCounts = array_count_values($this->suites);

        if (max($suitsCounts) < 5) {
            return null;
        }

        $flushSuit = array_search(max($suitsCounts), $suitsCounts);

        $flushCards = $cards->filter(function(Card $card) use ($flushSuit) {
            return $card->getSuit() === $flushSuit;
        });

       sort($flushCards);
        if (count($flushCards) === 6) {
            unset($flushCards[0]);
        } elseif (count($flushCards) === 7) {
            unset($flushCards[0]);
            unset($flushCards[1]);
        }
        $flushCards = array_values($flushCards);

        return new Flush(new CardsCollection($flushCards), $this->playerCards);
    }

    /**
     * @return FullHouse|null
     */
    private function checkFullHouse(): ?FullHouse
    {
        $set = $this->checkSet();
        $twoSets = $this->checkTwoSets();
        $pair = $this->checkPair();
        $twoPairs = $this->checkTwoPairs();

        if ($twoSets) {
            return new FullHouse($twoSets->getFullHouseCards(), $this->playerCards);
        }

        if ($pair && $set) {
            $cards = $set->getOnlyCombinationCards()->merge($pair->getOnlyCombinationCards());

            return new FullHouse($cards, $this->playerCards);
        }

        if ($twoPairs && $set) {
            $twoPairsCards = $twoPairs->getOnlyCombinationCards()->slice(2, 2);
            $cards = $set->getOnlyCombinationCards()->merge($twoPairsCards);

            return new FullHouse($cards, $this->playerCards);
        }

        return null;
    }

    /**
     * @return Quad|null
     */
    private function checkQuad(): ?Quad
    {
        if (count($this->quads) !== 1) {
            return null;
        }

        $priorities = array_filter($this->priorities, function(int $priority) {
            return !in_array($priority, $this->quads, true);
        });
        rsort($priorities);

        $combinationPriorities = array_merge(
            $this->quads,
            array_slice($priorities, 0, 1)
        );

        $combinationCards = $this->cards->getCardsByPriorities($combinationPriorities);
        $onlyCombinationCards = $this->cards->getCardsByPriorities($this->quads);

        return new Quad($combinationCards, $this->playerCards, $onlyCombinationCards);
    }

    /**
     * @return StraightFlush|null
     */
    private function checkStraightFlush(): ?StraightFlush
    {
        if (
            $this->checkFlush()
            &&
            $straight = $this->checkStraight()
        ) {
            return new StraightFlush(
                $straight->getOnlyCombinationCards(),
                $this->playerCards
            );
        }

        return null;
    }

    /**
     * @return RoyalFlush|null
     */
    private function checkRoyalFlush(): ?RoyalFlush
    {
        if (!$straightFlush = $this->checkStraightFlush()) {
            return null;
        }

        if (!$straightFlush->getOnlyCombinationCards()->getCardsByPriorities(13)->count()) {
            return null;
        }

        return new RoyalFlush($straightFlush->getOnlyCombinationCards(), $this->playerCards);
    }

    /**
     * Find multiple cards combinations(pairs, sets, quads)
     */
    private function getPrioritiesCounts(): void
    {
        $prioritiesCounts = array_count_values($this->priorities);

        foreach ($prioritiesCounts as $priority => $count) {
            if ($count === 2) {
                $this->pairs[] = $priority;
            } elseif ($count === 3) {
                $this->sets[] = $priority;
            } elseif ($count === 4) {
                $this->quads[] = $priority;
            }
        }

        if (count($this->pairs) > 2) {
            unset($this->pairs[array_search(min($this->pairs), $this->pairs)]);
        }

        sort($this->pairs);
    }
}