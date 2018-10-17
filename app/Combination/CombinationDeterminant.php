<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 11:19
 */

namespace App\Combination;


use App\Card;

class CombinationDeterminant
{
    /**
     * @var Card[] $tableCards
     * */
    private $tableCards;

    /**
     * @var Card[] $playerCards
     * */
    private $playerCards;

    /**
     * CombinationCalculator constructor.
     * @param Card[] $tableCards
     * @param Card[] $playerCards
     */
    public function __construct(array $tableCards, array $playerCards)
    {
        $this->tableCards = $tableCards;
        $this->playerCards = $playerCards;
    }
}