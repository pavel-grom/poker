<?php

namespace Pagrom\Poker\Traits;


use Pagrom\Poker\Interfaces\CombinationInterface;

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