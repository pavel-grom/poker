<?php

namespace Pagrom\Poker\Tests\WinnerDetermination;


use Pagrom\Poker\Combination\Straight;

class StraightTest extends TestCase
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
                    [1, 1], [3, 2]
                ],
            ],
            /*table*/
            [
                [11, 1], [10, 2], [9, 3], [7, 4], [5, 4]
            ],
            /*winners*/
            ['player1'],
            /*candidates*/
            ['player1'],
        ],
        [
            /*players*/
            [
                'player1' => [
                    [13, 2], [12, 3]
                ],
                'player2' => [
                    [13, 1], [12, 2]
                ],
            ],
            /*table*/
            [
                [11, 1], [10, 2], [9, 3], [7, 4], [5, 4]
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
                    [13, 2], [1, 3]
                ],
                'player2' => [
                    [8, 1], [8, 2]
                ],
            ],
            /*table*/
            [
                [2, 1], [3, 2], [4, 3], [7, 4], [9, 4]
            ],
            /*winners*/
            ['player1'],
            /*candidates*/
            ['player1'],
        ],
        [
            /*players*/
            [
                'player1' => [
                    [11, 2], [13, 3]
                ],
                'player2' => [
                    [8, 1], [4, 2]
                ],
            ],
            /*table*/
            [
                [2, 1], [3, 2], [4, 3], [5, 4], [6, 4]
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
                    [11, 2], [7, 3]
                ],
                'player2' => [
                    [8, 1], [4, 2]
                ],
            ],
            /*table*/
            [
                [2, 1], [3, 2], [4, 3], [5, 4], [6, 4]
            ],
            /*winners*/
            ['player1'],
            /*candidates*/
            ['player1'],
        ],
        [
            /*players*/
            [
                'player1' => [
                    [13, 2], [4, 3]
                ],
                'player2' => [
                    [5, 1], [4, 2]
                ],
            ],
            /*table*/
            [
                [2, 1], [12, 2], [11, 3], [1, 4], [3, 4]
            ],
            /*winners*/
            ['player2'],
            /*candidates*/
            ['player2'],
        ],
    ];

    /**
     * @var string
     * */
    protected $combination = Straight::class;
}