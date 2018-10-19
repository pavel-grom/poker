<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 12:15
 */

namespace App;


use App\Exceptions\GameLogicException;
use App\Interfaces\HasCardsInterface;
use App\Traits\HasCardsTrait;

class DeckOfCards implements HasCardsInterface
{
    use HasCardsTrait;

    /**
     * DeckOfCards constructor.
     */
    public function __construct()
    {
        $this->fill();
    }

    /**
     * Get card and remove its from deck
     *
     * @param int $priority
     * @param int $suit
     * @return Card
     */
    public function dealCard(int $priority, int $suit): Card
    {
        if ($this->cards->count() === 0) {
            throw new GameLogicException('Deck of cards is empty');
        }

        return $this->cards->getCard($priority, $suit);
    }

    /**
     * Get randoms cards and remove them from deck
     *
     * @param int $count
     * @return CardsCollection
     */
    public function dealRandomCards(int $count = 1): CardsCollection
    {
        if ($this->cards->count() === 0) {
            throw new GameLogicException('Deck of cards is empty');
        }

        $cards = [];

        for ($i = 0; $i < $count; $i++) {
            $cards[] = $this->cards->getRandomCard();
        }

        return new CardsCollection($cards);
    }

    /**
     *  Fill the deck with cards
     */
    private function fill(): void
    {
        $cards = [];

        foreach (range(1, 13) as $priority) {
            foreach (range(1, 4) as $suit) {
                $cards[] = Card::make($priority, $suit);
            }
        }

        $this->cards = new CardsCollection($cards);
    }
}