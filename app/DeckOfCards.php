<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 12:15
 */

namespace App;


use App\Interfaces\HasCardsInterface;
use App\Traits\HasCardsTrait;

class DeckOfCards implements HasCardsInterface
{
    use HasCardsTrait;

    /**
     * array $cardsIndexes
     * */
    private $cardsIndexes = [];

    /**
     * DeckOfCards constructor.
     */
    public function __construct()
    {
        $this->fill();
        $this->indexCards();
    }

    /**
     * Get card and remove its from deck
     *
     *
     * @param Card|null $specificCard
     * @return Card
     * @throws GameLogicException
     */
    public function dealCard(?Card $specificCard = null): Card
    {
        if (count($this->cards) === 0) {
            throw new GameLogicException('Deck of cards is empty');
        }

        if (!$specificCard) {
            $cardsKeys = array_keys($this->cards);
            shuffle($cardsKeys);
            $randomCardKey = array_rand($cardsKeys);

            $card = $this->cards[$randomCardKey];
            unset($this->cards[$randomCardKey]);

            return $card;
        }

        $cardKey = $this->findCard($specificCard);
        $card = $this->cards[$cardKey];
        unset($this->cards[$cardKey]);

        return $card;
    }

    /**
     * Find card and return its key
     *
     * @param Card $card
     * @return int
     */
    private function findCard(Card $card): int
    {
        if (!isset($this->cardsIndexes[$this->getCardIndexKey($card)])) {
            throw new GameLogicException('Unknown card index');
        }

        return $this->cardsIndexes[$this->getCardIndexKey($card)];
    }

    /**
     * Index cards for more quickly search
     */
    private function indexCards(): void
    {
        if (empty($this->cards)) {
            throw new GameLogicException('No cards to index. First fill cards');
        }

        foreach ($this->cards as $key => $card) {
            $this->cardsIndexes[$this->getCardIndexKey($card)] = $key;
        }
    }

    /**
     * @param Card $card
     * @return string
     */
    private function getCardIndexKey(Card $card): string
    {
        return "{$card->getPriority()}|{$card->getSuit()}";
    }

    /**
     *  Fill the deck with cards
     */
    private function fill(): void
    {
        foreach (range(1, 13) as $priority) {
            foreach (range(1, 4) as $suit) {
                $this->cards[] = new Card($priority, $suit);
            }
        }
    }
}