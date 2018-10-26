<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 019 19.10.18
 * Time: 15:49
 */

namespace Pagrom\Poker\Combination;


use Pagrom\Poker\Interfaces\HasKickerInterface;
use Pagrom\Poker\Interfaces\HasTwoKickersInterface;
use Pagrom\Poker\Interfaces\OnePriorityOrientedCombinationInterface;
use Pagrom\Poker\Interfaces\PlayerInterface;
use Pagrom\Poker\Interfaces\TwoPriorityOrientedCombinationInterface;
use Pagrom\Poker\Table;

class WinnerDeterminant
{
    /**
     * @var Table
     */
    private $table;

    /**
     * @var PlayerInterface[]
     * */
    private $winners;

    /**
     * @var PlayerInterface[]
     * */
    private $candidates;

    /**
     * WinningCombinationDeterminant constructor.
     * @param Table $table
     */
    public function __construct(Table $table)
    {
        $this->table = $table;
        $this->determineWinnersAndCandidates();
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
     * @return bool
     */
    public function isNeedKicker(): bool
    {
        if (
            !($this->winners[0]->getCombination() instanceof HasKickerInterface)
            || count($this->candidates) <= count($this->winners)
        ) {
            return false;
        }

        $combinationPriorities = [];

        foreach ($this->table->getPlayers() as $player) {
            /** @var OnePriorityOrientedCombinationInterface $combination */
            $combination = $player->getCombination();
            $combinationPriorities[] = $combination->getPriority();
        }

        return count($combinationPriorities) > count(array_unique($combinationPriorities));
    }

    /**
     * @return bool
     */
    public function isNeedSecondKicker(): bool
    {
        if (!$this->isNeedKicker() || !($this->winners[0]->getCombination() instanceof HasTwoKickersInterface)) {
            return false;
        }

        $kickersPriorities = [];

        foreach ($this->table->getPlayers() as $player) {
            /** @var HasTwoKickersInterface $combination */
            $combination = $player->getCombination();
            $kicker = $combination->getKicker();
            if ($kicker) {
                $kickersPriorities[] = $kicker->getPriority();
            }
        }

        return count($kickersPriorities) > count(array_unique($kickersPriorities));
    }

    /**
     * Determine winners and candidates
     */
    private function determineWinnersAndCandidates(): void
    {
        $weights = [];
        $totalWeights = [];

        $players = $this->table->getPlayers();

        foreach ($players as $name => $player) {
            $combination = $player->getCombination();
            $weight = $combination::WEIGHT;
            if ($combination instanceof OnePriorityOrientedCombinationInterface) {
                $priority = $combination->getPriority();
                $weight .= $priority > 9 ? $priority : '0' . $priority;
            } else {
                $weight .= '00';
            }
            if ($combination instanceof TwoPriorityOrientedCombinationInterface) {
                $secondPriority = $combination->getSecondPriority();
                $weight .= $secondPriority > 9 ? $secondPriority : '0' . $secondPriority;
            } else {
                $weight .= '00';
            }
            $weights[$name] = (int) $weight;
            $totalWeights[$name] = $combination->getTotalWeight();
        }

        $maxWeight = max($weights);
        $maxTotalWeight = max($totalWeights);

        $candidates = [];

        foreach ($weights as $playerName => $weight) {
            if ($weight === $maxWeight) {
                $candidates[] = $players[$playerName];
            }
        }

        $winners = [];

        foreach ($totalWeights as $playerName => $totalWeight) {
            if ($totalWeight === $maxTotalWeight) {
                $winners[] = $players[$playerName];
            }
        }

        $this->winners = $winners;
        $this->candidates = $candidates;
    }
}