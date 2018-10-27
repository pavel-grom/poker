<?php

use Pagrom\Poker\Tests\CombinationDetermination\TestCase;


class TwoPairsTest extends TestCase
{
    /**
     * cards for testing
     * format: [[player cards, table cards]]
     * card format: [priority, suit]
     *
     * @var array
     * */
    protected $cardsCombinations = [
        [[[13, 1], [13, 2]], [[12, 1], [12, 2], [5, 3], [7, 4], [9, 1]]],
        [[[13, 1], [12, 2]], [[12, 1], [13, 2], [5, 3], [7, 4], [9, 1]]],
        [[[12, 1], [13, 2]], [[13, 1], [12, 2], [5, 3], [7, 4], [9, 1]]],
        [[[1, 1], [13, 2]], [[13, 1], [12, 2], [12, 3], [7, 4], [9, 1]]],
        [[[1, 1], [3, 2]], [[13, 1], [12, 2], [12, 3], [13, 4], [9, 1]]],
    ];

    /**
     * @var string
     * */
    protected $combination = \Pagrom\Poker\Combination\TwoPairs::class;
}