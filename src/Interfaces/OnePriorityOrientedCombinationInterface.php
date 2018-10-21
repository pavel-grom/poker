<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 020 20.10.18
 * Time: 16:41
 */

namespace Pagrom\Poker\Interfaces;


interface OnePriorityOrientedCombinationInterface
{
    /**
     * @return int
     */
    public function getPriority(): int;
}