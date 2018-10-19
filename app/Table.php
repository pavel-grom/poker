<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 11:27
 */

namespace App;


use App\Exceptions\GameLogicException;
use App\Interfaces\HasCardsInterface;
use App\Interfaces\HasCombinationInterface;
use App\Interfaces\PlayerInterface;
use App\Traits\HasCardsTrait;
use App\Traits\HasCombinationTrait;

class Table implements HasCardsInterface, HasCombinationInterface
{
    use HasCardsTrait, HasCombinationTrait;

    /**
     * @var PlayerInterface[] $players
     * */
    private $players = [];

    /**
     * @var DeckOfCards
     * */
    private $deckOfCards;
    /**
     * @var callable|null
     */
    private $randomizer;

    /**
     * Table constructor.
     * @param callable|null $randomizer - function(int[] $cardsKeys): int
     */
    public function __construct(?callable $randomizer = null)
    {
        $this->deckOfCards = new DeckOfCards($randomizer);
        $this->randomizer = $randomizer;
    }

    /**
     * @param PlayerInterface $player
     */
    public function addPlayer(PlayerInterface $player): void
    {
        $this->players[$player->getName()] = $player;
    }

    /**
     * Deal specified card to player or table
     *
     * @param HasCardsInterface $hasCards player or table
     * @param int $priority
     * @param int $suit
     */
    public function dealCard(HasCardsInterface $hasCards, int $priority, int $suit): void
    {
        $card = $this->deckOfCards->dealCard($priority, $suit);

        $hasCards->addCard($card);
    }

    /**
     * Deal random cards to players and table. If their already has cards - deal missing cards or skip
     */
    public function dealCards(): void
    {
        foreach ($this->players as $player) {
            $playerCardsCount = $player->getCards()->count();
            $neededCountForDealing = 2 - $playerCardsCount;
            if ($neededCountForDealing > 0) {
                $cards = $this->deckOfCards->dealRandomCards($neededCountForDealing);
                foreach ($cards as $card) {
                    $player->addCard($card);
                }
            }
        }

        $tableCardsCount = $this->getCards()->count();
        $neededCountForDealing = 5 - $tableCardsCount;
        if ($neededCountForDealing > 0) {
            $cards = $this->deckOfCards->dealRandomCards($neededCountForDealing);
            foreach ($cards as $card) {
                $this->addCard($card);
            }
        }
    }

    /**
     * @return PlayerInterface[]
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    /**
     * @param string $name
     * @return PlayerInterface
     */
    public function getPlayer(string $name): PlayerInterface
    {
        if (!isset($this->players[$name])) {
            throw new GameLogicException('Unknown player ' . $name);
        }

        return $this->players[$name];
    }
}