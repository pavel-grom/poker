<?php

namespace Pagrom\Poker\Tests\WinnerDetermination;


use Pagrom\Poker\Combination\RoyalFlush;

class RoyalFlushTest extends TestCase
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
                    [13, 1], [12, 1]
                ],
                'player2' => [
                    [1, 1], [3, 2]
                ],
            ],
            /*table*/
            [
                [11, 1], [10, 1], [9, 1], [5, 4], [3, 4]
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
    protected $combination = RoyalFlush::class;
}