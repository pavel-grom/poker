<?php

namespace Pagrom\Poker;


use Pagrom\Poker\Exceptions\GameLogicException;

class DeckOfCards
{
    /**
     * @var CardsCollection $cards
     * */
    private $cards;
    /**
     * DeckOfCards constructor.
     * @param callable|null $randomizer - function(int[] $cardsKeys): int
     */
    public function __construct(?callable $randomizer = null)
    {
        $this->fill($randomizer);
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
     * @param callable|null $randomizer - function(int[] $cardsKeys): int
     */
    private function fill(?callable $randomizer = null): void
    {
        $cards = [];

        foreach (range(1, 13) as $priority) {
            foreach (range(1, 4) as $suit) {
                $cards[] = Card::make($priority, $suit);
            }
        }

        $this->cards = new CardsCollection($cards, 0, 'ArrayIterator', $randomizer);
    }
	/**
     * @return CardsCollection
     */
    public function getCards(): CardsCollection
    {
        return $this->cards ?? new CardsCollection([]);
    }
}