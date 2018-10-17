<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 11:40
 */

namespace App\Traits;


use App\Card;

trait HasCardsTrait
{
    /**
     * @var Card[] $cards
     * */
    private $cards = [];

    /**
     * @return Card[]
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    /**
     * @param Card $card
     */
    public function addCard(Card $card): void
    {
        $this->cards[] = $card;
    }
}