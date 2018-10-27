<?php

namespace Pagrom\Poker\Tests\WinnerDetermination;


use Pagrom\Poker\Combination\TwoPairs;

class TwoPairsTest extends TestCase
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
                    [13, 2], [12, 3]
                ],
                'player2' => [
                    [13, 1], [11, 2]
                ],
            ],
            /*table*/
            [
                [1, 1], [3, 2], [13, 3], [9, 4], [9, 1]
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
                    [13, 2], [13, 3]
                ],
                'player2' => [
                    [13, 1], [13, 4]
                ],
            ],
            /*table*/
            [
                [1, 1], [3, 2], [5, 3], [9, 4], [9, 1]
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
                    [13, 2], [12, 1]
                ],
                'player2' => [
                    [13, 3], [12, 4]
                ],
            ],
            /*table*/
            [
                [1, 1], [3, 2], [5, 3], [12, 3], [13, 1]
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
                    [13, 2], [12, 3]
                ],
                'player2' => [
                    [13, 1], [11, 4]
                ],
            ],
            /*table*/
            [
                [1, 1], [3, 2], [10, 3], [10, 4], [13, 3]
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
                    [8, 2], [12, 3]
                ],
                'player2' => [
                    [7, 1], [11, 4]
                ],
            ],
            /*table*/
            [
                [1, 1], [10, 2], [10, 3], [13, 4], [13, 3]
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
                    [8, 2], [7, 3]
                ],
                'player2' => [
                    [7, 1], [6, 4]
                ],
            ],
            /*table*/
            [
                [9, 1], [12, 2], [12, 3], [13, 4], [13, 3]
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
    protected $combination = TwoPairs::class;
}