<?php

namespace Pagrom\Poker\Interfaces;


use Pagrom\Poker\Card;

interface HasTwoKickersInterface extends HasKickerInterface
{
    /**
     * @return Card|null
     */
    public function getSecondKicker(): ?Card;
}