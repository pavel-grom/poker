<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

/**
 * Description of Player
 *
 * @author m1x
 */
class Player
{
    public $name;
    public $cards;
    public $combination;
    public $inGame = true;
    
    public function __construct($name) 
    {
        $this->name = $name;
    }
}
