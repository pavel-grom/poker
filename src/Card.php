<?php

namespace Pagrom\Poker;


use Pagrom\Poker\Exceptions\GameLogicException;

class Card
{
    /**
     * @var int $priority
     * */
    private $priority;

    /**
     * @var int $suit
     * */
    private $suit;

    /**
     * Card constructor.
     * @param int $priority
     * @param int $suit
     */
    public function __construct(int $priority, int $suit)
    {
        $this->priority = $priority;
        $this->suit = $suit;
    }

    /**
     * @param int $priority
     * @param int $suit
     * @return Card
     */
    public static function make(int $priority, int $suit): self
    {
        if (
            !in_array($priority, range(1, 13), true)
            ||
            !in_array($suit, range(1, 4), true)
        ) {
            throw new GameLogicException('Unknown card - ' . $priority . '|' . $suit);
        }

        return new self($priority, $suit);
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @return int
     */
    public function getSuit(): int
    {
        return $this->suit;
    }

    /**
     * @return string
     */
    public function getWeight(): string
    {
        return $this->priority >= 10
            ? (string) $this->priority
            : "0{$this->priority}";
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getPriority() . '|' . $this->getSuit();
    }
    /**
     * returns int for sorting comparation
     * @return int
     */
    public function getSortPriority():int
    {
        return $this->getSuit()*100+$this->getPriority();   
    }
}