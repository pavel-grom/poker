<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 13:11
 */

namespace Pagrom\Poker\Combination;


use Pagrom\Poker\CardsCollection;
use Pagrom\Poker\Interfaces\CombinationInterface;

abstract class CombinationAbstract implements CombinationInterface
{
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
     * @var CardsCollection
     */
    protected $playerOnlyCombinationCards;

    /**
     * @var CardsCollection
     */
    protected $playerOnlyNotCombinationCards;

    /**
     * CombinationAbstract constructor.
     * @param CardsCollection $cards Combination cards
     * @param CardsCollection $playerCards
     * @param CardsCollection|null $onlyCombinationCards
     */
    public function __construct(CardsCollection $cards, CardsCollection $playerCards, ?CardsCollection $onlyCombinationCards = null)
    {
        $this->cards = $cards->values();
        $this->playerCards = $playerCards->values();
        $this->onlyCombinationCards = ($onlyCombinationCards ?? $cards)->values();
        $this->onlyNotCombinationCards = $this->cards->diff($this->onlyCombinationCards)->values();
        $this->playerOnlyCombinationCards = $this->playerCards->intersect($this->onlyCombinationCards)->values();
        $this->playerOnlyNotCombinationCards = $this->playerCards->intersect($this->onlyNotCombinationCards)->values();
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

    /**
     * @return CardsCollection
     */
    public function getPlayerCards(): CardsCollection
    {
        return $this->playerCards;
    }

    /**
     * @return CardsCollection
     */
    public function getSortedCards(): CardsCollection
    {
        return $this->cards->sortByPriority(true);
    }

    /**
     * @return CardsCollection
     */
    public function getPlayerOnlyCombinationCards(): CardsCollection
    {
        return $this->playerOnlyCombinationCards;
    }

    /**
     * @return CardsCollection
     */
    public function getPlayerOnlyNotCombinationCards(): CardsCollection
    {
        return $this->playerOnlyNotCombinationCards;
    }
}