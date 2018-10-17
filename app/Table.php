<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 11:27
 */

namespace App;


use App\Interfaces\HasCardsInterface;
use App\Interfaces\PlayerInterface;
use App\Traits\HasCardsTrait;

class Table implements HasCardsInterface
{
    use HasCardsTrait;

    /**
     * @var PlayerInterface[] $players
     * */
    private $players = [];

    /**
     * @var DeckOfCards
     * */
    private $deckOfCards;

    /**
     * Table constructor.
     * @param DeckOfCards $deckOfCards
     */
    public function __construct(DeckOfCards $deckOfCards)
    {
        $this->deckOfCards = $deckOfCards;
    }

    /**
     * @param PlayerInterface $player
     */
    public function addPlayer(PlayerInterface $player): void
    {
        $this->players[] = $player;
    }

    /**
     * @return PlayerInterface[]
     */
    public function getPlayers()
    {
        return $this->players;
    }


}