<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 13:06
 */

namespace Pagrom\Poker\Combination;


use Pagrom\Poker\Card;
use Pagrom\Poker\CardsCollection;
use Pagrom\Poker\Interfaces\HasKickerInterface;
use Pagrom\Poker\Interfaces\OnePriorityOrientedCombinationInterface;

class Quad extends CombinationAbstract implements HasKickerInterface, OnePriorityOrientedCombinationInterface
{
    /**
     * @const int WEIGHT
     * */
    public const WEIGHT = 8;

    /**
     * @return int
     */
    public function getTotalWeight(): int
    {
        $totalWeight = self::WEIGHT;

        $totalWeight .= $this->onlyCombinationCards->random()->getWeight();
        $totalWeight .= $this->onlyNotCombinationCards[0]->getWeight();

        $totalWeight .= '000000';

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
        return $this->onlyCombinationCards[0]->getPriority();
    }
}