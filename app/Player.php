<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 017 17.10.18
 * Time: 11:29
 */

namespace App;


use App\Interfaces\HasCardsInterface;
use App\Interfaces\PlayerInterface;
use App\Traits\HasCardsTrait;

class Player implements HasCardsInterface, PlayerInterface
{
    use HasCardsTrait;

    /**
     * @var string $name
     * */
    private $name;

    /**
     * Player constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}