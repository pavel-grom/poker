<?php

namespace Pagrom\Poker\Interfaces;


interface PlayerInterface extends HasCardsInterface, HasCombinationInterface
{
    public const MAX_CARDS_COUNT = 2;

    /**
     * @return string
     */
    public function getName(): string;
}