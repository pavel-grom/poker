<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 12:03
 */

namespace Pagrom\Poker\Interfaces;


interface PlayerInterface extends HasCardsInterface, HasCombinationInterface
{
    /**
     * @return string
     */
    public function getName(): string;
}