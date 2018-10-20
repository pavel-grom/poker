<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 13:03
 */

namespace App\Combination;


use App\Card;
use App\CardsCollection;
use App\Interfaces\HasKickerInterface;
use App\Interfaces\TwoPriorityOrientedCombinationInterface;

class TwoPairs extends CombinationAbstract implements HasKickerInterface, TwoPriorityOrientedCombinationInterface
{
    /**
     * @const int WEIGHT
     * */
    public const WEIGHT = 3;

    /**
     * @return int
     */
    public function getTotalWeight(): int
    {
        $totalWeight = self::WEIGHT;

        $onlyCombinationCardsPriorities = $this->onlyCombinationCards->getUniquePriorities();

        foreach ($onlyCombinationCardsPriorities as $priority) {
            if ($priority < 10) {
                $priority = "0{$priority}";
            }
            $totalWeight .= $priority;
        }

        foreach ($this->onlyNotCombinationCards->sortByPriority(true) as $card) {
            $totalWeight .= $card->getWeight();
        }

        $missedCardsCount = 5 - $this->onlyNotCombinationCards->count() - count($onlyCombinationCardsPriorities);

        for ($i = 0; $i < $missedCardsCount; $i++) {
            $totalWeight .= '00';
        }

        return (int) $totalWeight;
    }

    /**
     * @return Card|null
     */
    public function getKicker(): ?Card
    {
        return $this->playerOnlyNotCombinationCards[0] ?? null;
    }

    /**
     * @return CardsCollection
     */
    public function getSortedCards(): CardsCollection
    {
        return $this->onlyCombinationCards->merge($this->onlyNotCombinationCards);
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->onlyCombinationCards->sortByPriority(true)[0]->getPriority();
    }

    /**
     * @return int
     */
    public function getSecondPriority(): int
    {
        return $this->onlyCombinationCards->sortByPriority()[0]->getPriority();
    }
}