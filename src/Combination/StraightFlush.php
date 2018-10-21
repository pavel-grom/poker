<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 13:07
 */

namespace Pagrom\Poker\Combination;


use Pagrom\Poker\Card;
use Pagrom\Poker\Interfaces\OnePriorityOrientedCombinationInterface;
use Pagrom\Poker\Interfaces\SuitOrientedCombinationInterface;

class StraightFlush extends CombinationAbstract implements OnePriorityOrientedCombinationInterface, SuitOrientedCombinationInterface
{
    /**
     * @const int WEIGHT
     * */
    public const WEIGHT = 9;

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
        return $this->onlyCombinationCards->sortByPriority(true)[0]->getPriority();
    }

    /**
     * @return int
     */
    public function getSuit(): int
    {
        return $this->cards[0]->getSuit();
    }
}