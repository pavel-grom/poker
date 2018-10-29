<?php

namespace Pagrom\Poker\Tests\CombinationDetermination;


use Pagrom\Poker\Card;
use Pagrom\Poker\CardsCollection;
use Pagrom\Poker\Combination\CombinationDeterminant;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * cards for testing
     * format: [[player cards, table cards]]
     * card format: [priority, suit]
     *
     * @var array
     * */
    protected $cardsCombinations;

    /**
     * @var string
     * */
    protected $combination;

    /**
     * @return array
     */
    public function data_provider()
    {
        return array_map(function(array $allCards){
            [$playerCards, $tableCards] = $allCards;

            $playerCardsCollection = [];

            foreach ($playerCards as $card) {
                [$priority, $suit] = $card;
                $playerCardsCollection[] = Card::make($priority, $suit);
            }

            $playerCardsCollection = new CardsCollection($playerCardsCollection);

            $tableCardsCollection = [];

            foreach ($tableCards as $card) {
                [$priority, $suit] = $card;
                $tableCardsCollection[] = Card::make($priority, $suit);
            }

            $tableCardsCollection = new CardsCollection($tableCardsCollection);

            return [$playerCardsCollection, $tableCardsCollection];

        }, $this->cardsCombinations);
    }


    /**
     * @dataProvider data_provider
     * @param $playerCards
     * @param $tableCards
     */
    public function test($playerCards, $tableCards)
    {
        $combinationDeterminant = new CombinationDeterminant(
            $tableCards,
            $playerCards
        );

        $this->assertCombination($combinationDeterminant->getCombination());
    }

    /**
     * @param $combination
     */
    protected function assertCombination($combination)
    {
        $this->assertInstanceOf($this->combination, $combination);
    }
}