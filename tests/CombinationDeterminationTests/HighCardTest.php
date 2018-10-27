<?php

use Pagrom\Poker\Tests\CombinationDetermination\TestCase;


class HighCardTest extends TestCase
{
    /**
     * cards for testing
     * format: [[player cards, table cards]]
     * card format: [priority, suit]
     *
     * @var array
     * */
    protected $cardsCombinations = [
        [[[13, 1], [12, 2]], [[1, 1], [3, 2], [5, 3], [7, 4], [9, 1]]],
        [[[12, 1], [11, 2]], [[1, 1], [3, 2], [5, 3], [7, 4], [9, 1]]],
        [[[11, 1], [10, 2]], [[1, 1], [3, 2], [5, 3], [7, 4], [9, 1]]],
        [[[10, 1], [9, 2]], [[1, 1], [3, 2], [5, 3], [7, 4], [8, 1]]],
        [[[9, 1], [8, 2]], [[1, 1], [3, 2], [5, 3], [7, 4], [2, 1]]],
        [[[8, 1], [7, 2]], [[1, 1], [3, 2], [5, 3], [6, 4], [2, 1]]],
        [[[7, 1], [6, 2]], [[1, 1], [3, 2], [5, 3], [9, 4], [2, 1]]],
        [[[7, 1], [6, 2]], [[13, 1], [12, 2], [5, 3], [9, 4], [2, 1]]],
        [[[1, 2], [6, 2]], [[13, 1], [12, 2], [5, 3], [9, 4], [4, 1]]],
        [[[10, 2], [6, 2]], [[13, 1], [12, 2], [5, 3], [9, 4], [4, 1]]],
    ];

    /**
     * @var string
     * */
    protected $combination = \Pagrom\Poker\Combination\HighCard::class;
}