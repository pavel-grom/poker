<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 019 19.10.18
 * Time: 20:07
 */

namespace App\Interfaces;


use App\Card;

interface HasKickerInterface
{
    /**
     * @return Card|null
     */
    public function getKicker(): ?Card;
}