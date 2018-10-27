<?php

namespace Pagrom\Poker\Tests\WinnerDetermination;


use Pagrom\Poker\Combination\StraightFlush;

class StraightFlushTest extends TestCase
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
                    [12, 1], [11, 1]
                ],
                'player2' => [
                    [1, 1], [3, 2]
                ],
            ],
            /*table*/
            [
                [10, 1], [9, 1], [8, 1], [5, 4], [3, 4]
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
                    [13, 1], [1, 1]
                ],
                'player2' => [
                    [8, 1], [8, 2]
                ],
            ],
            /*table*/
            [
                [2, 1], [3, 1], [4, 1], [7, 4], [9, 4]
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
                [2, 1], [3, 1], [4, 1], [5, 1], [6, 1]
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
                    [11, 2], [7, 1]
                ],
                'player2' => [
                    [8, 1], [4, 2]
                ],
            ],
            /*table*/
            [
                [2, 1], [3, 1], [4, 1], [5, 1], [6, 1]
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
    protected $combination = StraightFlush::class;
}