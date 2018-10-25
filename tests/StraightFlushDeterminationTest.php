<?php

use PHPUnit\Framework\CombinationDeterminationTestCase;


class StraightFlushDeterminationTest extends CombinationDeterminationTestCase
{
    /**
     * cards for testing
     * format: [[player cards, table cards]]
     * card format: [priority, suit]
     *
     * @var array
     * */
    protected $cardsCombinations = [
        [[[13, 1], [1, 1]], [[2, 1], [3, 1], [4, 1], [8, 4], [9, 1]]],
        [[[13, 1], [12, 1]], [[2, 1], [3, 1], [4, 1], [1, 1], [9, 3]]],
        [[[9, 1], [12, 2]], [[2, 1], [3, 1], [4, 1], [1, 1], [13, 1]]],
        [[[1, 1], [2, 1]], [[3, 1], [4, 1], [5, 1], [8, 4], [9, 3]]],
        [[[12, 1], [11, 1]], [[10, 1], [9, 1], [8, 1], [4, 4], [3, 4]]],
        [[[7, 1], [3, 2]], [[12, 1], [11, 1], [10, 1], [9, 1], [8, 1]]],
    ];

    /**
     * @var string
     * */
    protected $combination = \Pagrom\Poker\Combination\StraightFlush::class;
}