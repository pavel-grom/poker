<?php

namespace PHPUnit\Framework;


abstract class CombinationDeterminationTestCase extends \PHPUnit\Framework\TestCase
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
                $playerCardsCollection[] = \Pagrom\Poker\Card::make($priority, $suit);
            }

            $playerCardsCollection = new \Pagrom\Poker\CardsCollection($playerCardsCollection);

            $tableCardsCollection = [];

            foreach ($tableCards as $card) {
                [$priority, $suit] = $card;
                $tableCardsCollection[] = \Pagrom\Poker\Card::make($priority, $suit);
            }

            $tableCardsCollection = new \Pagrom\Poker\CardsCollection($tableCardsCollection);

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
        $combinationDeterminant = new \Pagrom\Poker\Combination\CombinationDeterminant(
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