<?php

namespace Pagrom\Poker\Interfaces;


use Pagrom\Poker\Card;

interface HasKickerInterface
{
    /**
     * @return Card|null
     */
    public function getKicker(): ?Card;
}