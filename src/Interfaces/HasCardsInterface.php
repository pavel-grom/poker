<?php

namespace Pagrom\Poker\Interfaces;


use Pagrom\Poker\Card;
use Pagrom\Poker\CardsCollection;

interface HasCardsInterface
{
    /**
     * @return CardsCollection
     */
    public function getCards(): CardsCollection;

    /**
     * @param Card $card
     */
    public function addCard(Card $card): void;
}