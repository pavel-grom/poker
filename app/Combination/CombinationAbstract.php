<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 13:11
 */

namespace App\Combination;


use App\Card;
use App\GameLogicException;
use App\Interfaces\CombinationInterface;
use App\Interfaces\HasCardsInterface;
use App\Traits\HasCardsTrait;

abstract class CombinationAbstract implements CombinationInterface, HasCardsInterface
{
    use HasCardsTrait{
        addCard as addCardTrait;
    }

    /**
     * @const int WEIGHT
     * */
    public const WEIGHT = 1;

    /**
     * Combination can have max 5 cards
     *
     * @const int MAX_CARDS_COUNT
     * */
    protected const MAX_CARDS_COUNT = 5;

    /**
     * @return int
     */
    public function getTotalWeight(): int
    {
        $totalWeight = self::WEIGHT;

        foreach ($this->cards as $card) {
            $totalWeight .= $card->getWeight();
        }

        return (int) $totalWeight;
    }

    /**
     * @param Card $card
     */
    public function addCard(Card $card): void
    {
        if (count($this->cards) === self::MAX_CARDS_COUNT) {
            throw new GameLogicException('Combination can have max 5 cards');
        }

        $this->addCardTrait($card);
    }
}