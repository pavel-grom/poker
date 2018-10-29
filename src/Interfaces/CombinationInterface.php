<?php

namespace Pagrom\Poker\Interfaces;


use Pagrom\Poker\CardsCollection;

interface CombinationInterface
{
    /**
     * @return int
     */
    public function getTotalWeight(): int;

    /**
     * @return CardsCollection
     */
    public function getCards(): CardsCollection;

    /**
     * @return CardsCollection
     */
    public function getSortedCards(): CardsCollection;

    /**
     * @return CardsCollection
     */
    public function getOnlyCombinationCards(): CardsCollection;

    /**
     * @return CardsCollection
     */
    public function getOnlyNotCombinationCards(): CardsCollection;

    /**
     * @return CardsCollection
     */
    public function getPlayerCards(): CardsCollection;

    /**
     * @return CardsCollection
     */
    public function getPlayerOnlyCombinationCards(): CardsCollection;

    /**
     * @return CardsCollection
     */
    public function getPlayerOnlyNotCombinationCards(): CardsCollection;
}