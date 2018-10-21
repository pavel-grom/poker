<?php

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

$pokerHelper = new \Pagrom\Poker\PokerHelper();

$table = new \Pagrom\Poker\Table();

$table->addPlayer(new \Pagrom\Poker\Player('Dean'));
$table->addPlayer(new \Pagrom\Poker\Player('Sam'));

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

foreach ($table->getPlayers() as $player) {
    $playerCombinationDeterminant = new \Pagrom\Poker\Combination\CombinationDeterminant($table->getCards(), $player->getCards());
    $combination = $playerCombinationDeterminant->getCombination();
    $player->setCombination($combination);
}

$tableCombinationDeterminant = new \Pagrom\Poker\Combination\CombinationDeterminant($table->getCards());
$table->setCombination($tableCombinationDeterminant->getCombination());

$winnerDeterminant = new \Pagrom\Poker\Combination\WinnerDeterminant($table);
$winners = $winnerDeterminant->getWinners();

foreach ($table->getPlayers() as $player) {
    $cards = $player->getCards()->map(function(\Pagrom\Poker\Card $card) use ($pokerHelper) {
        return $pokerHelper->getCardName($card);
    });
    dump($player->getName());
    dump($cards);
}

dump('Table');
$tableCards = $table->getCards()->map(function(\Pagrom\Poker\Card $card) use ($pokerHelper) {
    return $pokerHelper->getCardName($card);
});
dump($tableCards);

dump('Winners:');
foreach ($winners as $winner) {
    dump($winner->getName());
    dump($pokerHelper->getCombinationData($winners[0]->getCombination(), $winnerDeterminant->isNeedKicker(), $winnerDeterminant->isNeedSecondKicker()));
}


