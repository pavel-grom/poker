<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 13:07
 */

namespace App\Combination;


class RoyalFlush extends CombinationAbstract
{
    /**
     * @const int WEIGHT
     * */
    public const WEIGHT = 10;

    /**
     * @return int
     */
    public function getTotalWeight(): int
    {
        $totalWeight = self::WEIGHT;

        $totalWeight .= '0000000000';

        return (int) $totalWeight;
    }
}