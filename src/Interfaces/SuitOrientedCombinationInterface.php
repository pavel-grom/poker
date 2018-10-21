<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 020 20.10.18
 * Time: 16:43
 */

namespace Pagrom\Poker\Interfaces;


interface SuitOrientedCombinationInterface
{
    /**
     * @return int
     */
    public function getSuit(): int;
}