<?php

namespace Pagrom\Poker;


use Pagrom\Poker\Combination\WinnerDeterminant;
use Pagrom\Poker\Exceptions\GameLogicException;
use Pagrom\Poker\Interfaces\CombinationDeterminantInterface;
use Pagrom\Poker\Interfaces\GameTypeInterface;
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
     * @var GameTypeInterface
     * */
    private $gameType;

    /**
     * @var int
     * */
    private $cardsCount;

    /**
     * @var PlayerInterface[]
     * */
    private $winners;

    /**
     * @var PlayerInterface[]
     * */
    private $candidates;

    /**
     * @var WinnerDeterminant
     * */
    private $winnerDeterminant;

    /**
     * Table constructor.
     * @param GameTypeInterface $gameType Set of rules ex. Holdem or Omaha game type class.
     * @param callable|null $randomizer - function(int[] $cardsKeys): int
     */
     
    public function __construct(GameTypeInterface $gameType, ?callable $randomizer = null)
    {
        $this->deckOfCards = new DeckOfCards($randomizer);
        $this->randomizer = $randomizer;
        $this->gameType = $gameType;
        $this->cardsCount = $gameType->getTableCardsCount();
    }

    /**
     * @param PlayerInterface $player
     * @return Table
     */
    public function addPlayer(PlayerInterface $player): self
    {
        $player->cardsCount = $this->gameType->getPlayerCardsCount();
        $this->players[$player->getName()] = $player;

        return $this;
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

        $this->checkMaxCards($hasCards);
    }

    /**
     * Deal random cards to players and table. If their already has cards - deal missing cards or skip
     * @return self
     */
    public function dealCards(): self
    {
        foreach ($this->players as $player) {
            $playerCardsCount = $player->getCards()->count();
            $neededCountForDealing = $this->gameType->getPlayerCardsCount() - $playerCardsCount;
            if ($neededCountForDealing > 0) {
                $cards = $this->deckOfCards->dealRandomCards($neededCountForDealing);
                foreach ($cards as $card) {
                    $player->addCard($card);
                }
                $this->checkMaxCards($player);
            }
        }

        $tableCardsCount = $this->getCards()->count();
        $neededCountForDealing = $this->gameType->getTableCardsCount() - $tableCardsCount;
        if ($neededCountForDealing > 0) {
            $cards = $this->deckOfCards->dealRandomCards($neededCountForDealing);
            foreach ($cards as $card) {
                $this->addCard($card);
            }
            $this->checkMaxCards($this);
        }

        return $this;
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

        $this->checkMaxCards($hasCards);
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
     * @return CombinationDeterminantInterface
     */
    public function getCombinationDeterminant(): CombinationDeterminantInterface
    {
        return $this->gameType->getCombinationDeterminant();
    }

    /**
     * @return self
     */
    public function determineCombinations(): self
    {
        foreach ($this->getPlayers() as $player) {
            $combination = $this->getCombinationDeterminant()->getCombination($this->getCards(), $player->getCards());
            $player->setCombination($combination);
        }

        return $this;
    }

    /**
     * @return self
     */
    public function determineWinners(): self
    {
        $this->winnerDeterminant = new WinnerDeterminant($this);
        $this->winners = $this->winnerDeterminant->getWinners();
        $this->candidates = $this->winnerDeterminant->getCandidates();

        return $this;
    }

    /**
     * @return PlayerInterface[]
     */
    public function getWinners(): array
    {
        return $this->winners;
    }

    /**
     * @return PlayerInterface[]
     */
    public function getCandidates(): array
    {
        return $this->candidates;
    }

    /**
     * @return WinnerDeterminant
     */
    public function getWinnerDeterminant(): WinnerDeterminant
    {
        return $this->winnerDeterminant;
    }

    /**
     * @param $cardPattern
     * @return array
     */
    private function getCardParamsByPattern($cardPattern): array
    {
        return explode('|', $cardPattern);
    }

    /**
     * @param HasCardsInterface $hasCards
     * @return void
     */
    private function checkMaxCards(HasCardsInterface $hasCards): void
    {
        if ($hasCards instanceof Table) {
            $maxCardsCount = $this->gameType->getTableCardsCount();
        } elseif ($hasCards instanceof PlayerInterface) {
            $maxCardsCount = $this->gameType->getPlayerCardsCount();
        } else {
            throw new GameLogicException('Something was wrong');
        }

        if ($hasCards->getCards()->count() > $maxCardsCount) {
            throw new GameLogicException(get_class($hasCards) . ' has max cards count');
        }
    }
}