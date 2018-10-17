<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 11:20
 */

namespace App;


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
     * @param string $priority
     * @param string $suit
     * @return Card
     */
    public static function makeByName(string $priority, string $suit): self
    {
        $config = Config::getInstance();

        $prioritiesMapFlip = array_flip($config->get('cards_priorities_map'));
        $suitesMapFlip = array_flip($config->get('cards_suites_map'));

        $priority = $prioritiesMapFlip[$priority] ?? null;
        $suit = $suitesMapFlip[$suit] ?? null;

        if (is_null($priority) || is_null($suit)) {
            throw new GameLogicException('Unknown card');
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
}