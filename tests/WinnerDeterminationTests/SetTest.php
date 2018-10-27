<?php

namespace Pagrom\Poker\Tests\WinnerDetermination;


use Pagrom\Poker\Combination\Set;

class SetTest extends TestCase
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
                    [13, 2], [13, 3]
                ],
                'player2' => [
                    [13, 1], [11, 2]
                ],
            ],
            /*table*/
            [
                [1, 1], [3, 2], [5, 3], [9, 4], [13, 4]
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
                    [13, 1], [11, 2]
                ],
            ],
            /*table*/
            [
                [1, 1], [3, 2], [5, 3], [13, 3], [13, 4]
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
                    [11, 2], [12, 3]
                ],
                'player2' => [
                    [9, 1], [11, 3]
                ],
            ],
            /*table*/
            [
                [1, 1], [3, 2], [13, 1], [13, 3], [13, 4]
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
                    [11, 2], [12, 3]
                ],
                'player2' => [
                    [11, 1], [12, 4]
                ],
            ],
            /*table*/
            [
                [1, 1], [3, 2], [13, 1], [13, 3], [13, 4]
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
                    [5, 2], [7, 3]
                ],
                'player2' => [
                    [1, 1], [6, 4]
                ],
            ],
            /*table*/
            [
                [10, 1], [12, 2], [13, 1], [13, 3], [13, 4]
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
                    [5, 2], [7, 3]
                ],
                'player2' => [
                    [1, 1], [6, 4]
                ],
            ],
            /*table*/
            [
                [10, 1], [12, 2], [2, 1], [4, 3], [9, 4]
            ],
            /*winners*/
            [],
            /*candidates*/
            [],
        ],
    ];

    /**
     * @var string
     * */
    protected $combination = Set::class;
}