<?php

/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 024 24.10.18
 * Time: 21:14
 */
class TestCase extends \PHPUnit\Framework\TestCase
{
    protected $pokerHelper;
    protected $table;

    public function setUp()
    {
        $this->pokerHelper = new \Pagrom\Poker\PokerHelper();
        $this->table = new \Pagrom\Poker\Table();
    }
}