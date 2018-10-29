<?php

namespace Pagrom\Poker\Tests\CombinationDetermination;


use Pagrom\Poker\Combination\FullHouse;

class FullHouseTest extends TestCase
{
    /**
     * cards for testing
     * format: [[player cards, table cards]]
     * card format: [priority, suit]
     *
     * @var array
     * */
    protected $cardsCombinations = [
        [[[13, 1], [13, 2]], [[13, 3], [12, 4], [12, 3], [7, 4], [9, 1]]],
        [[[13, 1], [12, 2]], [[13, 3], [12, 4], [12, 3], [7, 4], [9, 1]]],
        [[[2, 1], [12, 2]], [[13, 3], [12, 4], [12, 3], [13, 4], [9, 1]]],
        [[[2, 1], [4, 2]], [[13, 3], [12, 4], [12, 3], [13, 4], [13, 1]]],
        [[[2, 1], [4, 2]], [[13, 3], [12, 4], [12, 3], [13, 4], [12, 1]]],
    ];

    /**
     * @var string
     * */
    protected $combination = FullHouse::class;
}