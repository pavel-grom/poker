<?php

use PHPUnit\Framework\CombinationDeterminationTestCase;


class PairDeterminationTest extends CombinationDeterminationTestCase
{
    /**
     * cards for testing
     * format: [[player cards, table cards]]
     * card format: [priority, suit]
     *
     * @var array
     * */
    protected $cardsCombinations = [
        [[[13, 1], [13, 2]], [[1, 1], [3, 2], [5, 3], [7, 4], [9, 1]]],
        [[[13, 1], [12, 2]], [[13, 2], [3, 2], [5, 3], [7, 4], [9, 1]]],
        [[[13, 1], [12, 2]], [[12, 1], [3, 2], [5, 3], [7, 4], [9, 1]]],
        [[[13, 1], [12, 2]], [[10, 1], [10, 2], [5, 3], [7, 4], [9, 1]]],
    ];

    /**
     * @var string
     * */
    protected $combination = \Pagrom\Poker\Combination\Pair::class;
}