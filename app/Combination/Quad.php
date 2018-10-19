<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 13:06
 */

namespace App\Combination;


class Quad extends CombinationAbstract
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

        $totalWeight .= '00000000';

        return (int) $totalWeight;
    }
}