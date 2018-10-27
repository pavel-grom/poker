<?php

namespace Pagrom\Poker\Tests\WinnerDetermination;


use Pagrom\Poker\Combination\WinnerDeterminant;
use Pagrom\Poker\Interfaces\PlayerInterface;
use Pagrom\Poker\Player;
use Pagrom\Poker\PokerHelper;
use Pagrom\Poker\Table;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var PokerHelper
     * */
    protected $pokerHelper;

    /**
     * @var array
     * */
    protected $testData;

    /**
     * @var string
     * */
    protected $combination;

    /**
     * @return array
     */
    public function data_provider()
    {
        return array_map(function(array $data){
            [$playersCards, $tableCards, $expectedWinners, $expectedCandidates] = $data;

            $table = new Table();

            foreach ($playersCards as $playerName => $playerCards) {
                $player = new Player($playerName);

                $table->addPlayer($player);
                foreach ($playerCards as $card) {
                    [$priority, $suit] = $card;
                    $table->dealCard($player, $priority, $suit);
                }
            }

            foreach ($tableCards as $card) {
                [$priority, $suit] = $card;
                $table->dealCard($table, $priority, $suit);
            }

            $pokerHelper = new PokerHelper();

            $pokerHelper->determineCombinations($table);

            $winnerDeterminant = new WinnerDeterminant($table);
            $winners = $winnerDeterminant->getWinners();
            $candidates = $winnerDeterminant->getCandidates();

            return [$winners, $expectedWinners, $candidates, $expectedCandidates];
        }, $this->testData);
    }

    /**
     * @dataProvider data_provider
     * @param $winners
     * @param $expectedWinners
     * @param $candidates
     * @param $expectedCandidates
     */
    public function test($winners, $expectedWinners, $candidates, $expectedCandidates)
    {
        $winnersNames = [];

        $needAssertInstance = $expectedWinners && $expectedCandidates;

        /** @var PlayerInterface $winner */
        foreach ($winners as $winner) {
            $winnersNames[] = $winner->getName();
            if ($needAssertInstance) {
                $this->assertInstanceOf($this->combination, $winner->getCombination());
            }
        }

        $candidatesNames = [];

        /** @var PlayerInterface $candidate */
        foreach ($candidates as $candidate) {
            $candidatesNames[] = $candidate->getName();
            if ($needAssertInstance) {
                $this->assertInstanceOf($this->combination, $candidate->getCombination());
            }
        }

        $this->assertEmpty(array_diff($expectedWinners, $winnersNames));
        $this->assertEmpty(array_diff($expectedCandidates, $candidatesNames));
    }
}