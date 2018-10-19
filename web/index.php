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

$table = new \App\Table();

$table->addPlayer(new \App\Player('Dean'));
$table->addPlayer(new \App\Player('Sam'));

$dean = $table->getPlayer('Dean');
$sam = $table->getPlayer('Sam');

$table->dealCard($dean, 12, 1);
$table->dealCard($dean, 13, 1);

$table->dealCard($sam, 8, 1);
$table->dealCard($sam, 2, 2);

$table->dealCard($table, 9, 1);
$table->dealCard($table, 10, 1);
$table->dealCard($table, 11, 1);
$table->dealCard($table, 8, 2);
$table->dealCard($table, 1, 4);

$table->dealCards();

foreach ($table->getPlayers() as $player) {
    $combinationDeterminant = new \App\Combination\CombinationDeterminant($table->getCards(),$player->getCards());
    $combination = $combinationDeterminant->determineCombination();
    $player->setCombination($combination);
}

$combinationDeterminant = new \App\Combination\CombinationDeterminant($table->getCards());
$table->setCombination($combinationDeterminant->determineCombination());
