<?php

use Pagrom\Poker\Tests\CombinationDetermination\TestCase;


class StraightTest extends TestCase
{
    /**
     * cards for testing
     * format: [[player cards, table cards]]
     * card format: [priority, suit]
     *
     * @var array
     * */
    protected $cardsCombinations = [
        [[[13, 1], [1, 2]], [[2, 3], [3, 2], [4, 3], [8, 4], [9, 1]]],
        [[[13, 1], [12, 2]], [[2, 3], [3, 2], [4, 3], [1, 4], [9, 1]]],
        [[[9, 1], [12, 2]], [[2, 3], [3, 2], [4, 3], [1, 4], [13, 1]]],
        [[[1, 1], [2, 2]], [[3, 3], [4, 2], [5, 3], [8, 4], [9, 1]]],
        [[[13, 1], [12, 2]], [[11, 3], [10, 2], [9, 3], [8, 4], [3, 1]]],
        [[[7, 1], [3, 2]], [[13, 3], [12, 2], [11, 3], [10, 4], [9, 1]]],
    ];

    /**
     * @var string
     * */
    protected $combination = \Pagrom\Poker\Combination\Straight::class;
}