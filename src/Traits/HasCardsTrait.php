<?php

namespace Pagrom\Poker\Traits;


use Pagrom\Poker\Card;
use Pagrom\Poker\CardsCollection;

trait HasCardsTrait
{
    /**
     * @var CardsCollection
     * */
    private $cards;

    /**
     * @return CardsCollection
     */
    public function getCards(): CardsCollection
    {
        return $this->cards ?? new CardsCollection();
    }

    /**
     * @param Card $card
     */
    public function addCard(Card $card): void
    {
        if (!($this->cards instanceof CardsCollection)) {
            $this->cards = new CardsCollection($this->cards ?? []);
        }
        $this->cards[] = $card;
    }
}