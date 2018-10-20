<?php

use App\Card;

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

$pokerHelper = new \App\PokerHelper();

$table = new \App\Table();

$table->addPlayer(new \App\Player('Dean'));
$table->addPlayer(new \App\Player('Sam'));

//$dean = $table->getPlayer('Dean');
//$sam = $table->getPlayer('Sam');
//
//$table->dealCard($dean, $pokerHelper->getPriorityByName('3'), $pokerHelper->getSuitByName('Club'));
//$table->dealCard($dean, $pokerHelper->getPriorityByName('A'), $pokerHelper->getSuitByName('Spade'));
//
//$table->dealCard($sam, $pokerHelper->getPriorityByName('3'), $pokerHelper->getSuitByName('Spade'));
//$table->dealCard($sam, $pokerHelper->getPriorityByName('6'), $pokerHelper->getSuitByName('Club'));
//
//$table->dealCard($table, $pokerHelper->getPriorityByName('6'), $pokerHelper->getSuitByName('Heart'));
//$table->dealCard($table, $pokerHelper->getPriorityByName('5'), $pokerHelper->getSuitByName('Diamond'));
//$table->dealCard($table, $pokerHelper->getPriorityByName('6'), $pokerHelper->getSuitByName('Spade'));
//$table->dealCard($table, $pokerHelper->getPriorityByName('A'), $pokerHelper->getSuitByName('Diamond'));
//$table->dealCard($table, $pokerHelper->getPriorityByName('2'), $pokerHelper->getSuitByName('Club'));

$table->dealCards();

foreach ($table->getPlayers() as $player) {
    $combinationDeterminant = new \App\Combination\CombinationDeterminant($table->getCards(), $player->getCards());
    $combination = $combinationDeterminant->determineCombination();
    $player->setCombination($combination);
}

$combinationDeterminant = new \App\Combination\CombinationDeterminant($table->getCards());
$table->setCombination($combinationDeterminant->determineCombination());

$winnerDeterminant = new \App\Combination\WinnerDeterminant($table);
$winners = $winnerDeterminant->getWinners();

foreach ($table->getPlayers() as $player) {
    $cards = $player->getCards()->map(function(Card $card) use ($pokerHelper) {
        return $pokerHelper->getCardName($card);
    });
    dd($player->getName(), 0);
    dd($cards, 0);
}

dd('Table', 0);
$tableCards = $table->getCards()->map(function(Card $card) use ($pokerHelper) {
    return $pokerHelper->getCardName($card);
});
dd($tableCards, 0);

dd('Winners:', 0);
foreach ($winners as $winner) {
    dd($winner->getName(), 0);
    dd($pokerHelper->getCombinationData($winners[0]->getCombination()), 0);
}


