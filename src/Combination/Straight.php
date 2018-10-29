<?php

namespace Pagrom\Poker\Combination;


use Pagrom\Poker\Card;
use Pagrom\Poker\CardsCollection;
use Pagrom\Poker\Interfaces\OnePriorityOrientedCombinationInterface;

class Straight extends CombinationAbstract implements OnePriorityOrientedCombinationInterface
{
    /**
     * @const int WEIGHT
     * */
    public const WEIGHT = 5;

    /**
     * @return int
     */
    public function getTotalWeight(): int
    {
        $totalWeight = self::WEIGHT;

        $cards = $this->cards->map(function(Card $card){
            return $card->getWeight();
        });
        rsort($cards);

        $totalWeight .= $cards[0];
        $totalWeight .= '00000000';

        return (int) $totalWeight;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        $onlyCombinationCards = $this->onlyCombinationCards->sortByPriority(true);
        $highPriority = $onlyCombinationCards[0]->getPriority();
        $lowPriority = $onlyCombinationCards[4]->getPriority();

        return $highPriority === 13 && $lowPriority === 1
            ? $onlyCombinationCards[1]->getPriority()
            : $highPriority;
    }

    /**
     * @return CardsCollection
     */
    public function getSortedCards(): CardsCollection
    {
        $onlyCombinationCards = $this->onlyCombinationCards->sortByPriority(true);

        if ($onlyCombinationCards[0]->getPriority() === 13 && $onlyCombinationCards[4]->getPriority() === 1) {
            return $this->cards->usort(function(Card $a, Card $b) {
                $priorityA = $a->getPriority();
                $priorityB = $b->getPriority();

                if ($priorityA === 13) {
                    return 1;
                }

                if ($priorityA === $priorityB) {
                    return 0;
                }

                return $priorityA > $priorityB ? -1 : 1;
            });
        }

        return parent::getSortedCards();
    }
}