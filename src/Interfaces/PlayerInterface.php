<?php

namespace Pagrom\Poker\Interfaces;


interface PlayerInterface extends HasCardsInterface, HasCombinationInterface
{
    /**
     * @return string
     */
    public function getName(): string;
}