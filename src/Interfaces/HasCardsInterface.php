<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 11:33
 */

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