<?php

namespace Pagrom\Poker\Tests\CombinationDetermination;


use Pagrom\Poker\Combination\Flush;

class FlushTest extends TestCase
{
    /**
     * cards for testing
     * format: [[player cards, table cards]]
     * card format: [priority, suit]
     *
     * @var array
     * */
    protected $cardsCombinations = [
        [[[2, 1], [4, 1]], [[1, 1], [3, 1], [9, 1], [7, 4], [12, 1]]],
        [[[2, 1], [4, 2]], [[1, 1], [3, 1], [9, 1], [7, 1], [12, 3]]],
        [[[2, 4], [4, 2]], [[1, 1], [3, 1], [9, 1], [7, 1], [12, 1]]],
    ];

    /**
     * @var string
     * */
    protected $combination = Flush::class;
}