<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 018 18.10.18
 * Time: 21:27
 */

namespace App\Traits;


use App\Interfaces\CombinationInterface;

trait HasCombinationTrait
{
    /**
     * @var CombinationInterface
     */
    private $combination;

    /**
     * @param CombinationInterface $combination
     */
    public function setCombination(CombinationInterface $combination): void
    {
        $this->combination = $combination;
    }

    /**
     * @return CombinationInterface|null
     */
    public function getCombination(): ?CombinationInterface
    {
        return $this->combination;
    }
}