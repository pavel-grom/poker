<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 13:04
 */

namespace Pagrom\Poker\Combination;


use Pagrom\Poker\Card;
use Pagrom\Poker\CardsCollection;
use Pagrom\Poker\Interfaces\TwoPriorityOrientedCombinationInterface;

class FullHouse extends CombinationAbstract implements TwoPriorityOrientedCombinationInterface
{
    /**
     * @const int WEIGHT
     * */
    public const WEIGHT = 7;

    /**
     * @return int
     */
    public function getTotalWeight(): int
    {
        $totalWeight = self::WEIGHT;

        $pairPriority = $this->getPairPriority();
        $setPriority = $this->getSetPriority();

        $pairWeight = $pairPriority >= $pairPriority ? '0' . $pairPriority : $pairPriority;
        $setWeight = $setPriority >= $setPriority ? '0' . $setPriority : $setPriority;

        $totalWeight .= $setWeight . $pairWeight;

        $totalWeight .= '000000';

        return (int) $totalWeight;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->getSetPriority();
    }

    /**
     * @return int
     */
    public function getSecondPriority(): int
    {
        return $this->getPairPriority();
    }

    /**
     * @return CardsCollection
     */
    public function getSortedCards(): CardsCollection
    {
        $prioritiesCounts = $this->getPrioritiesCounts();

        return $this->cards->usort(function(Card $a, Card $b) use ($prioritiesCounts) {
            $priorityCountA = $prioritiesCounts[$a->getPriority()];
            $priorityCountB = $prioritiesCounts[$b->getPriority()];

            if ($priorityCountA === $priorityCountB) {
                return 0;
            }

            return $priorityCountA > $priorityCountB ? -1 : 1;
        });
    }

    /**
     * @return int
     */
    private function getSetPriority(): int
    {
        $counts = $this->getPrioritiesCounts();

        return array_search(max($counts), $counts);
    }

    /**
     * @return int
     */
    private function getPairPriority(): int
    {
        $counts = $this->getPrioritiesCounts();

        return array_search(min($counts), $counts);
    }

    /**
     * @return int[]
     */
    private function getPrioritiesCounts(): array
    {
        $priorities = $this->onlyCombinationCards->map(function(Card $card){
            return $card->getPriority();
        });

        return array_count_values($priorities);
    }
}