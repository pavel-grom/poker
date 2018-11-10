<?php

namespace Pagrom\Poker;

use Pagrom\Poker\Exceptions\GameLogicException;
use ArrayObject;

class CardsCollection extends ArrayObject
{
    /**
     * @var int[]
     * */
    private $cardsIndexes = [];

    /**
     * Randomize callback for dealing cards
     *
     * @var callable|null
     */
    private $randomizer;

    /**
     * CardsCollection constructor.
     * @param array $input
     * @param int $flags
     * @param string $iterator_class
     * @param callable|null $randomizer - function(int[] $cardsKeys): int
     */
    public function __construct($input = [], $flags = 0, $iterator_class = "ArrayIterator", ?callable $randomizer = null)
    {
        foreach ($input as $item) {
            if (!($item instanceof Card)) {
                throw new GameLogicException('Wrong card instance');
            }
        }

        parent::__construct($input, $flags, $iterator_class);

        $this->indexCards();
        $this->randomizer = $randomizer;
    }

    /**
     * Merge cards collections
     *
     * @param CardsCollection $cardsCollection
     * @return CardsCollection
     */
    public function merge(self $cardsCollection): self
    {
        return new self(array_merge(
            (array) $this,
            (array) $cardsCollection
        ));
    }

    /**
     * @param callable $callback
     * @return array
     */
    public function map(callable $callback): array
    {
        return array_map($callback, (array) $this);
    }

    /**
     * @param callable $callback
     * @param int $flag
     * @return array
     */
    public function filter(callable $callback, int $flag = 0): array
    {
        return array_filter((array) $this, $callback, $flag);
    }

    /**
     * @param CardsCollection $cardsCollection
     * @return CardsCollection
     */
    public function diff(self $cardsCollection): self
    {
        return new self(array_diff((array) $this, (array) $cardsCollection));
    }

    /**
     * @param CardsCollection $cardsCollection
     * @return CardsCollection
     */
    public function intersect(self $cardsCollection): self
    {
        return new self(array_intersect((array) $this, (array) $cardsCollection));
    }

    /**
     * @return array
     */
    public function getUniquePriorities(): array
    {
        $priorities = $this->map(function(Card $card){
            return $card->getPriority();
        });

        $priorities = array_unique($priorities);

        rsort($priorities);

        return $priorities;
    }

    /**
     * @param callable $callback
     * @return CardsCollection
     */
    public function usort(callable $callback): self
    {
        $cards = (array) $this;

        usort($cards, $callback);

        return new self($cards);
    }

    /**
     * @param mixed $card
     */
    public function append($card)
    {
        if (!($card instanceof Card)) {
            throw new GameLogicException('Wrong card instance');
        }

        parent::append($card);

        $this->indexCard($this->count() - 1, $card);
    }

    /**
     * @param mixed $index
     * @param mixed $card
     */
    public function offsetSet($index, $card)
    {
        if (!($card instanceof Card)) {
            throw new GameLogicException('Wrong card instance');
        }

        parent::offsetSet($index, $card);

        $this->indexCard($index ?? $this->count() - 1, $card);
    }

    /**
     * @param bool $reverse
     * @return CardsCollection
     */
    public function sortByPriority(bool $reverse = false): self
    {
        $self = (array) $this;

        usort($self, function(Card $a, Card $b) use ($reverse) {
            if ($a->getPriority() === $b->getPriority()) {
                return 0;
            }

            $condition = $a->getPriority() < $b->getPriority();

            if ($reverse) {
                $leftSort = 1;
                $rightSort = -1;
            } else {
                $leftSort = -1;
                $rightSort = 1;
            }

            return $condition ? $leftSort : $rightSort;
        });

        return new CardsCollection($self);
    }

    /**
     * @return CardsCollection
     */
    public function values(): self
    {
        return new CardsCollection(array_values((array) $this));
    }

    /**
     * @param int $offset
     * @param int $length
     * @return CardsCollection
     */
    public function slice(int $offset, int $length): self
    {
        return new self(array_slice((array) $this, $offset, $length));
    }

    /**
     * Get card and remove from collection
     *
     * @param int $priority
     * @param int $suit
     * @return Card
     */
    public function getCard(int $priority, int $suit): Card
    {
        $cardKey = $this->findCard($priority, $suit);

        $card = $this[$cardKey];

        $this->removeCard($cardKey);

        return $card;
    }

    /**
     * Get random card and remove from collection
     *
     * @return Card
     */
    public function getRandomCard(): Card
    {
        if (!$randomizer = $this->randomizer) {
            $randomCardKey = array_rand((array) $this);
        } else {
            $cardsKeys = array_keys((array) $this);
            $randomCardKey = $randomizer($cardsKeys);
            if (!in_array($randomCardKey, $cardsKeys, true)) {
                throw new GameLogicException('Randomizer callback returns wrong value');
            }
        }

        $card = $this[$randomCardKey];

        $this->removeCard($randomCardKey);

        return $card;
    }

    /**
     * @return Card
     */
    public function random(): Card
    {
        return $this[array_rand((array) $this)];
    }

    /**
     * Remove random card
     */
    public function removeRandomCard(): void
    {
        $this->removeCard(array_rand((array) $this));
    }

    /**
     * @param $priorities
     * @return CardsCollection
     */
    public function getCardsByPriorities($priorities): self
    {
        if (is_int($priorities)) {
            $priorities = [$priorities];
        } elseif (!is_array($priorities)) {
            throw new GameLogicException('Priorities must be integer or array with integers');
        }

        $cards = $this->filter(function(Card $card) use ($priorities) {
            return in_array($card->getPriority(), $priorities, true);
        });
        $cards = array_values($cards);

        return new self($cards);
    }

    /**
     * Find card and return its key
     *
     * @param int $priority
     * @param int $suit
     * @return int
     */
    private function findCard(int $priority, int $suit): int
    {
        $index = $this->getCardIndexKeyByParams($priority, $suit);

        if (!isset($this->cardsIndexes[$index])) {
            throw new GameLogicException('Unknown card index or card already dealt - ' . $index);
        }

        return $this->cardsIndexes[$index];
    }

    /**
     * Index cards for more quickly search
     */
    private function indexCards(): void
    {
        if ($this->count() > 0) {
            foreach ($this as $key => $card) {
                $this->indexCard($key, $card);
            }
        }
    }

    /**
     * Index card
     * @param int $key
     * @param Card $card
     */
    private function indexCard(int $key, Card $card): void
    {
        $this->cardsIndexes[$this->getCardIndexKey($card)] = $key;
    }

    /**
     * @param int $key
     */
    private function removeCard(int $key): void
    {
        unset($this[$key]);
        $indexKey = array_search($key, $this->cardsIndexes);
        unset($this->cardsIndexes[$indexKey]);
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
     * @param int $priority
     * @param int $suit
     * @return string
     */
    private function getCardIndexKeyByParams(int $priority, int $suit): string
    {
        return "{$priority}|{$suit}";
    }
	/**
	 * @param int $cardcount
     * @return array of CardsCollection
     */
    public function getMathCombinationsCards(int $cardcount): array
    {
		if($this->count() < $cardcount)return [$this];
		$result = [];
		foreach($this as $index => $card){
			if($cardcount == 1){
				$newCards = new CardsCollection;
				$newCards->append($card);
				$result[] = $newCards;
			}else{
				$newCards = clone $this;
				$newCards->removeCard($index);
				foreach($newCards->getMathCombinationsCards($cardcount - 1) as $collection){
					$collection = new CardsCollection($collection->filter(function($iteratecard)use($card){
						return $card->getSortPriority() < $iteratecard->getSortPriority();
					}));
					$collection->append($card);
					if($collection->count() == $cardcount)
						$result[] = $collection->values();
					}
				}
			
			}
		return $result;
    }
}