<?php

use PHPUnit\Framework\CombinationDeterminationTestCase;


class QuadDeterminationTest extends CombinationDeterminationTestCase
{
    /**
     * cards for testing
     * format: [[player cards, table cards]]
     * card format: [priority, suit]
     *
     * @var array
     * */
    protected $cardsCombinations = [
        [[[13, 1], [13, 2]], [[13, 3], [13, 4], [5, 3], [7, 4], [9, 1]]],
        [[[13, 1], [4, 2]], [[13, 3], [13, 4], [13, 2], [7, 4], [9, 1]]],
        [[[2, 1], [4, 2]], [[13, 3], [13, 4], [13, 2], [13, 1], [9, 1]]],
    ];

    /**
     * @var string
     * */
    protected $combination = \Pagrom\Poker\Combination\Quad::class;
}