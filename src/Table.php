<?php

namespace Pagrom\Poker;


use Pagrom\Poker\Exceptions\GameLogicException;
use Pagrom\Poker\Interfaces\HasCardsInterface;
use Pagrom\Poker\Interfaces\PlayerInterface;
use Pagrom\Poker\Traits\HasCardsTrait;

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
     * @var callable|null
     */
    private $randomizer;

	/**
     * @var Gametype
     * */
	private $gametype;
    /**
     * Table constructor.
     * @param callable|null $randomizer - function(int[] $cardsKeys): int
     */
	 
    public function __construct($gametype,?callable $randomizer = null)
    {
        $this->deckOfCards = new DeckOfCards($randomizer);
        $this->randomizer = $randomizer;
		$this->gametype = $gametype;
		$this->cardcount = $gametype->getCardcountTable();
    }

    /**
     * @param PlayerInterface $player
     */
    public function addPlayer(PlayerInterface $player): void
    {
		$player->cardcount = $this->gametype->getCardcountPlayer();
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
            $neededCountForDealing = $this->gametype->getCardcountPlayer() - $playerCardsCount;
            if ($neededCountForDealing > 0) {
                $cards = $this->deckOfCards->dealRandomCards($neededCountForDealing);
                foreach ($cards as $card) {
                    $player->addCard($card);
                }
            }
        }

        $tableCardsCount = $this->getCards()->count();
        $neededCountForDealing = $this->gametype->getCardcountTable() - $tableCardsCount;
        if ($neededCountForDealing > 0) {
            $cards = $this->deckOfCards->dealRandomCards($neededCountForDealing);
            foreach ($cards as $card) {
                $this->addCard($card);
            }
        }
    }

    /**
     * @param HasCardsInterface $hasCards
     * @param string $cardPattern
     */
    public function dealCardByPattern(HasCardsInterface $hasCards, string $cardPattern): void
    {
        $cardParams = $this->getCardParamsByPattern($cardPattern);

        $card = $this->deckOfCards->dealCard($cardParams[0], $cardParams[1]);

        $hasCards->addCard($card);
    }

    /**
     * @param HasCardsInterface $hasCards
     * @param array $cardsPatterns
     */
    public function dealCardsByPattern(HasCardsInterface $hasCards, array $cardsPatterns): void
    {
        foreach ($cardsPatterns as $cardPattern) {
            $this->dealCardByPattern($hasCards, $cardPattern);
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

    /**
     * @param $cardPattern
     * @return array
     */
    private function getCardParamsByPattern($cardPattern): array
    {
        return explode('|', $cardPattern);
    }
	public function getCombinationDeterminant(CardsCollection $tableCards, ?CardsCollection $playerCards = null){
		return $this->gametype->getCombinationDeterminant($tableCards,$playerCards);
	}
}