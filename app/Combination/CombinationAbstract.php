<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 13:11
 */

namespace App\Combination;


use App\CardsCollection;
use App\Interfaces\CombinationInterface;

abstract class CombinationAbstract implements CombinationInterface
{
    /**
     * @const int
     * */
    public const WEIGHT = 1;

    /**
     * Combination can have max 5 cards
     *
     * @const int
     * */
    protected const MAX_CARDS_COUNT = 5;

    /**
     * @var CardsCollection
     */
    protected $playerCards;

    /**
     * @var CardsCollection
     */
    protected $cards;

    /**
     * @var CardsCollection
     */
    protected $onlyCombinationCards;

    /**
     * @var CardsCollection
     */
    protected $onlyNotCombinationCards;

    /**
     * CombinationAbstract constructor.
     * @param CardsCollection $cards Combination cards
     * @param CardsCollection $playerCards
     * @param CardsCollection|null $onlyCombinationCards
     */
    public function __construct(CardsCollection $cards, CardsCollection $playerCards, ?CardsCollection $onlyCombinationCards = null)
    {
        $this->cards = $cards;
        $this->playerCards = $playerCards;
        $this->onlyCombinationCards = $onlyCombinationCards ?? $cards;
        $this->onlyNotCombinationCards = $this->cards->diff($this->onlyCombinationCards);
    }

    /**
     * @return CardsCollection
     */
    public function getCards(): CardsCollection
    {
        return $this->cards ?? new CardsCollection();
    }

    /**
     * @return CardsCollection
     */
    public function getOnlyCombinationCards(): CardsCollection
    {
        return $this->onlyCombinationCards;
    }

    /**
     * @return CardsCollection
     */
    public function getOnlyNotCombinationCards(): CardsCollection
    {
        return $this->onlyNotCombinationCards;
    }
}