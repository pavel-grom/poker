<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 019 19.10.18
 * Time: 15:49
 */

namespace App\Combination;


use App\Interfaces\PlayerInterface;
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
     * WinningCombinationDeterminant constructor.
     * @param Table $table
     */
    public function __construct(Table $table)
    {
        $this->table = $table;
        $this->winners = $this->determineWinners();
    }

    /**
     * @return PlayerInterface[]
     */
    public function getWinners(): array
    {
        return $this->winners;
    }

    /**
     * Get winners array
     *
     * @return PlayerInterface[]
     */
    private function determineWinners(): array
    {
        $weights = [];

        /** @var PlayerInterface[] $players */
        $players = $this->table->getPlayers();

        foreach ($players as $name => $player) {
            $combinationWeight = $player->getCombination()->getTotalWeight();
            $weights[$name] = $combinationWeight;
        }

        $maxWeight = max($weights);

        $winners = [];

        foreach ($weights as $playerName => $weight) {
            if ($weight === $maxWeight) {
                $winners[] = $players[$playerName];
            }
        }

        return $winners;
    }
}