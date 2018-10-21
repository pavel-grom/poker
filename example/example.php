<?php

use Pagrom\Poker\Card;
use Pagrom\Poker\Combination\WinnerDeterminant;
use Pagrom\Poker\Player;
use Pagrom\Poker\PokerHelper;
use Pagrom\Poker\Table;

error_reporting(E_ALL);
ini_set('display_errors', 1);
require __DIR__.'/../vendor/autoload.php';

function dump($wtf) {
    echo '<pre>';
    print_r($wtf);
    echo '</pre>';
}

function dd($wtf) {
    dump($wtf);
    exit;
}

$pokerHelper = new PokerHelper();

$table = new Table();

$table->addPlayer(new Player('Dean'));
$table->addPlayer(new Player('Sam'));

// deal cards manually
//$dean = $table->getPlayer('Dean');
//$sam = $table->getPlayer('Sam');
//
//$table->dealCard($dean, $pokerHelper->getPriorityByName('Q'), $pokerHelper->getSuitByName('Spade'));
//$table->dealCard($dean, $pokerHelper->getPriorityByName('A'), $pokerHelper->getSuitByName('Spade'));
//
//$table->dealCard($sam, $pokerHelper->getPriorityByName('4'), $pokerHelper->getSuitByName('Spade'));
//$table->dealCard($sam, $pokerHelper->getPriorityByName('7'), $pokerHelper->getSuitByName('Club'));
//
//$table->dealCard($table, $pokerHelper->getPriorityByName('5'), $pokerHelper->getSuitByName('Heart'));
//$table->dealCard($table, $pokerHelper->getPriorityByName('2'), $pokerHelper->getSuitByName('Spade'));
//$table->dealCard($table, $pokerHelper->getPriorityByName('2'), $pokerHelper->getSuitByName('Diamond'));
//$table->dealCard($table, $pokerHelper->getPriorityByName('3'), $pokerHelper->getSuitByName('Heart'));
//$table->dealCard($table, $pokerHelper->getPriorityByName('4'), $pokerHelper->getSuitByName('Club'));

$table->dealCards();

$pokerHelper->determineCombinations($table);

$winnerDeterminant = new WinnerDeterminant($table);
$winners = $winnerDeterminant->getWinners();

foreach ($table->getPlayers() as $player) {
    $cards = $player->getCards()->map(function(Card $card) use ($pokerHelper) {
        return $pokerHelper->getCardName($card);
    });
    dump($player->getName());
    dump($cards);
}

dump('Table');
$tableCards = $table->getCards()->map(function(Card $card) use ($pokerHelper) {
    return $pokerHelper->getCardName($card);
});
dump($tableCards);

dump('Winners:');
foreach ($winners as $winner) {
    dump($winner->getName());
    dump($pokerHelper->getCombinationData($winner->getCombination(), $winnerDeterminant));
}


