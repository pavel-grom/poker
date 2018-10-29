<?php

namespace Pagrom\Poker\Tests\CombinationDetermination;


use Pagrom\Poker\Combination\Set;

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
    protected $combination = Set::class;
}