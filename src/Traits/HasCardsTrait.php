<?php

namespace Pagrom\Poker\Traits;


use Pagrom\Poker\Card;
use Pagrom\Poker\CardsCollection;
use Pagrom\Poker\Exceptions\GameLogicException;

trait HasCardsTrait
{
    /**
     * @var CardsCollection $cards
     * */
    private $cards;

    /**
     * @return CardsCollection
     */
    public function getCards(): CardsCollection
    {
        return $this->cards ?? new CardsCollection([]);
    }


    /**
     * @param Card $card
     */
    public function addCard(Card $card): void
    {
        if ($this->cards && $this->cards->count() === $this->cardcount) {
            throw new GameLogicException('Player or table has max cards');
        }

        if (!($this->cards instanceof CardsCollection)) {
            $this->cards = new CardsCollection($this->cards ?? []);
        }
        $this->cards[] = $card;
    }
}