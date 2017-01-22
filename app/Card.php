<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

/**
 * Description of Card
 *
 * @author m1x
 */
class Card
{
    public $priority;
    public $suit;
    private $name;
    private $namedPriority;
    private $namedSuit;
    private $namedPriorities = [
        1 => 2, 2 => 3, 3 => 4, 4 => 5,
        5 => 6, 6 => 7, 7 => 8, 8 => 9,
        9 => 10, 10 => 'J', 11 => 'Q', 12 => 'K',
        13 => 'A',
    ];
    private $namedSuites = [
        1 => 'Heart', 2 => 'Diamond', 3 => 'Club', 4 => 'Spade'
    ];
    static $namedPrioritiesStatic = [
        1 => 2, 2 => 3, 3 => 4, 4 => 5,
        5 => 6, 6 => 7, 7 => 8, 8 => 9,
        9 => 10, 10 => 'J', 11 => 'Q', 12 => 'K',
        13 => 'A',
    ];
    static $namedSuitesStatic = [
        1 => 'Heart', 2 => 'Diamond', 3 => 'Club', 4 => 'Spade'
    ];
    
    public function __construct($priority, $suit)
    {
        $this->priority = $priority;
        $this->suit = $suit;
        $this->humanizePriority();
        $this->humanizeSuit();
        $this->humanize();
    }
    
    private function humanize()
    {
        $this->name = $this->namedPriority . ' ' . $this->namedSuit;
    }
    
    private function humanizePriority()
    {
        $this->namedPriority = $this->namedPriorities[$this->priority];
    }
    
    private function humanizeSuit()
    {
        $this->namedSuit = $this->namedSuites[$this->suit];
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getNamedPriority()
    {
        return $this->namedPriority;
    }
    
    public function getNamedSuit()
    {
        return $this->namedSuit;
    }
    
    static public function create($priority, $suit)
    {
        if (!array_search($priority, self::$namedPrioritiesStatic)
            || !array_search($suit, self::$namedSuitesStatic)) {
            throw new \Exception('Wrong card');
        }
        return new self(
                array_search($priority, self::$namedPrioritiesStatic), 
                array_search($suit, self::$namedSuitesStatic)
        );
    }
}
