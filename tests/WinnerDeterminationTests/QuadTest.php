<?php

namespace Pagrom\Poker\Tests\WinnerDetermination;


use Pagrom\Poker\Combination\Quad;

class QuadTest extends TestCase
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
                [1, 1], [3, 2], [5, 3], [13, 1], [13, 4]
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
                    [12, 1], [11, 2]
                ],
            ],
            /*table*/
            [
                [1, 1], [3, 2], [13, 3], [13, 1], [13, 4]
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
                    [9, 2], [12, 3]
                ],
                'player2' => [
                    [12, 1], [11, 2]
                ],
            ],
            /*table*/
            [
                [1, 1], [13, 2], [13, 3], [13, 1], [13, 4]
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
    protected $combination = Quad::class;
}