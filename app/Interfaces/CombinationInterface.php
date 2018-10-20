<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 11:09
 */

namespace App\Interfaces;


use App\CardsCollection;

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