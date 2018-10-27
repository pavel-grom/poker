<?php

namespace Pagrom\Poker\Tests\WinnerDetermination;


use Pagrom\Poker\Combination\Flush;

class FlushTest extends TestCase
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
                    [13, 1], [11, 1]
                ],
                'player2' => [
                    [1, 1], [3, 2]
                ],
            ],
            /*table*/
            [
                [10, 1], [8, 1], [6, 1], [5, 4], [3, 4]
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
                    [13, 1], [11, 1]
                ],
                'player2' => [
                    [12, 1], [1, 1]
                ],
            ],
            /*table*/
            [
                [10, 1], [8, 1], [6, 1], [5, 4], [3, 4]
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
                    [13, 1], [11, 2]
                ],
                'player2' => [
                    [12, 2], [1, 4]
                ],
            ],
            /*table*/
            [
                [10, 1], [8, 1], [6, 1], [5, 1], [3, 4]
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
                    [13, 3], [11, 2]
                ],
                'player2' => [
                    [12, 3], [1, 4]
                ],
            ],
            /*table*/
            [
                [10, 1], [8, 1], [6, 1], [5, 1], [3, 1]
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
    protected $combination = Flush::class;
}