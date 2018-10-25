<?php

use PHPUnit\Framework\CombinationDeterminationTestCase;


class RoyalFlushDeterminationTest extends CombinationDeterminationTestCase
{
    /**
     * cards for testing
     * format: [[player cards, table cards]]
     * card format: [priority, suit]
     *
     * @var array
     * */
    protected $cardsCombinations = [
        [[[13, 1], [12, 1]], [[11, 1], [10, 1], [9, 1], [8, 4], [9, 2]]],
        [[[13, 2], [12, 2]], [[11, 2], [10, 2], [9, 2], [8, 1], [9, 3]]],
        [[[13, 3], [12, 3]], [[11, 3], [10, 3], [9, 3], [8, 2], [9, 4]]],
        [[[13, 4], [12, 4]], [[11, 4], [10, 4], [9, 4], [8, 1], [9, 3]]],
        [[[1, 1], [2, 3]], [[13, 4], [12, 4], [11, 4], [10, 4], [9, 4]]],
    ];

    /**
     * @var string
     * */
    protected $combination = \Pagrom\Poker\Combination\RoyalFlush::class;
}