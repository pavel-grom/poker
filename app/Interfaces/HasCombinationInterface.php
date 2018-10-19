<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 018 18.10.18
 * Time: 21:26
 */

namespace App\Interfaces;


interface HasCombinationInterface
{
    /**
     * @param CombinationInterface $combination
     */
    public function setCombination(CombinationInterface $combination): void;

    /**
     * @return CombinationInterface|null
     */
    public function getCombination(): ?CombinationInterface;
}