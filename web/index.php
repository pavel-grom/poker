<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require __DIR__.'/../vendor/autoload.php';
function dd($wtf, $exit = 1) {
    echo '<pre>';
    print_r($wtf);
    echo '</pre>';
    if ($exit) {
        exit();
    }
}

use App\Card;
use App\Table;
use App\Combinations\Combination;
use App\Player;

$table = new Table;
//for manualy dealing cards to players and table don`t use the $table->dealTheCards() method
/*
$cas = new Player('Cas');
$sam = new Player('Sam');
$cas->cards = [
    Card::create('7', 'Diamond'), 
    Card::create('3', 'Spade'),
];
$sam->cards = [
    Card::create('5', 'Heart'), 
    Card::create('8', 'Diamond'),
];
$table->tableCards = [
    Card::create('A', 'Club'), 
    Card::create('K', 'Diamond'),
    Card::create('10', 'Spade'), 
    Card::create('Q', 'Spade'),
    Card::create('J', 'Spade'), 
];
$table->addPlayers([
    $cas, 
    $sam, 
]);
$table->computeCombinations();
$table->getWinner();
*/
$table->addPlayers([
    new Player('Cas'), 
    new Player('Sam'), 
    new Player('Dean'),
    new Player('Crowley'), 
    new Player('Lucifer'),
]);
$table->dealTheCards(); // deal random cards to all players and table
$table->computeCombinations();
$table->getWinner();
$view = require_once '../app/view.php';



