<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 13:03
 */

namespace App\Combination;


use App\Card;
use App\Interfaces\OnePriorityOrientedCombinationInterface;

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
        return $this->onlyCombinationCards->sortByPriority(true)[0]->getPriority();
    }
}