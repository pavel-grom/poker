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
//$cas = new Player('Cas');
//$sam = new Player('Sam');
//$dean = new Player('Dean');
//
//$cas->cards = [
//    new Card(4, 1), 
//    new Card(12, 4),
//];
//$sam->cards = [
//    new Card(8, 2), 
//    new Card(12, 3),
//];
//$dean->cards = [
//    new Card(1, 1), 
//    new Card(3, 2),
//];
//$table->tableCards = [
//    new Card(2, 1), 
//    new Card(7, 2),
//    new Card(7, 3), 
//    new Card(11, 4),
//    new Card(11, 2), 
//];
//$table->addPlayers([
//    $cas, 
//    $sam, 
//    $dean
//]);

//$card = Card::create('A', 'Spade');
//dd($card);
$table->addPlayers([
    new Player('Cas'), 
    new Player('Sam'), 
    new Player('Dean'),
    new Player('Crowley'), 
    new Player('Lucifer'),
]);
$table->dealTheCards();
$table->computeCombinations();
$table->getWinner();

//dd($table->winners);
$view = require_once '../app/view.php';



