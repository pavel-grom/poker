<?php

namespace Pagrom\Poker\Tests\WinnerDetermination;


use Pagrom\Poker\Combination\FullHouse;

class FullHouseTest extends TestCase
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
                    [12, 1], [11, 2]
                ],
            ],
            /*table*/
            [
                [1, 1], [3, 2], [12, 3], [12, 2], [13, 4]
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
                    [13, 2], [12, 1]
                ],
                'player2' => [
                    [12, 4], [11, 2]
                ],
            ],
            /*table*/
            [
                [1, 1], [13, 1], [12, 3], [12, 2], [13, 4]
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
                    [1, 2], [3, 1]
                ],
                'player2' => [
                    [2, 4], [4, 2]
                ],
            ],
            /*table*/
            [
                [13, 1], [13, 2], [12, 3], [12, 2], [13, 4]
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
                    [1, 2], [13, 1]
                ],
                'player2' => [
                    [2, 4], [4, 2]
                ],
            ],
            /*table*/
            [
                [1, 1], [13, 2], [12, 3], [12, 2], [13, 4]
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
                    [13, 3], [1, 1]
                ],
                'player2' => [
                    [7, 4], [7, 2]
                ],
            ],
            /*table*/
            [
                [13, 1], [13, 2], [5, 3], [1, 2], [7, 3]
            ],
            /*winners*/
            ['player1'],
            /*candidates*/
            ['player1'],
        ],
    ];

    /**
     * @var string
     * */
    protected $combination = FullHouse::class;
}