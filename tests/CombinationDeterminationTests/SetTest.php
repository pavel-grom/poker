<?php

use Pagrom\Poker\Tests\CombinationDetermination\TestCase;


class SetTest extends TestCase
{
    /**
     * cards for testing
     * format: [[player cards, table cards]]
     * card format: [priority, suit]
     *
     * @var array
     * */
    protected $cardsCombinations = [
        [[[13, 1], [13, 2]], [[13, 3], [3, 2], [5, 3], [7, 4], [9, 1]]],
        [[[13, 1], [1, 2]], [[13, 3], [13, 2], [5, 3], [7, 4], [9, 1]]],
        [[[2, 1], [1, 2]], [[13, 3], [13, 2], [13, 1], [7, 4], [9, 1]]],
    ];

    /**
     * @var string
     * */
    protected $combination = \Pagrom\Poker\Combination\Set::class;
}