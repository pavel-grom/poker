<?php

namespace Pagrom\Poker\Tests\WinnerDetermination;


use Pagrom\Poker\Combination\HighCard;

class HighCardTest extends TestCase
{
    /**
     * cards for testing
     *
     * @var array
     * */
    protected $testData = [
        [
            /*players*/
            [
                'player1' => [
                    [13, 2], [12, 2]
                ],
                'player2' => [
                    [13, 1], [11, 2]
                ],
            ],
            /*table*/
            [
                [1, 1], [3, 2], [5, 3], [7, 4], [9, 1]
            ],
            /*winners*/
            ['player1'],
            /*candidates*/
            ['player1', 'player2'],
        ],
        [
            /*players*/
            [
                'player1' => [
                    [13, 2], [12, 2]
                ],
                'player2' => [
                    [13, 1], [12, 1]
                ],
            ],
            /*table*/
            [
                [1, 1], [3, 2], [5, 3], [7, 4], [9, 1]
            ],
            /*winners*/
            ['player1', 'player2'],
            /*candidates*/
            ['player1', 'player2'],
        ],
        [
            /*players*/
            [
                'player1' => [
                    [13, 2], [3, 2]
                ],
                'player2' => [
                    [13, 1], [2, 1]
                ],
            ],
            /*table*/
            [
                [11, 1], [12, 2], [9, 3], [7, 4], [5, 1]
            ],
            /*winners*/
            ['player1', 'player2'],
            /*candidates*/
            ['player1', 'player2'],
        ],
    ];

    /**
     * @var string
     * */
    protected $combination = HighCard::class;
}