<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 019 19.10.18
 * Time: 15:49
 */

namespace App\Combination;


use App\Interfaces\HasKickerInterface;
use App\Interfaces\HasTwoKickersInterface;
use App\Interfaces\OnePriorityOrientedCombinationInterface;
use App\Interfaces\PlayerInterface;
use App\Interfaces\TwoPriorityOrientedCombinationInterface;
use App\Table;

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
                $weight += $combination->getPriority();
            }
            if ($combination instanceof TwoPriorityOrientedCombinationInterface) {
                $weight += $combination->getSecondPriority();
            }
            $weights[$name] = $weight;
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