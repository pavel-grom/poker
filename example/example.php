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
//$table->dealCardsByPattern($dean, $pokerHelper->getCardPatternByNamedPatternArray([
//    'Q|Spade',
//    'Q|Club',
//]));
//
//$table->dealCardsByPattern($sam, $pokerHelper->getCardPatternByNamedPatternArray([
//    'J|Spade',
//    'J|Club',
//]));
//
//$table->dealCardsByPattern($table, $pokerHelper->getCardPatternByNamedPatternArray([
//    '5|Heart',
//    '2|Spade',
//    '2|Diamond',
//    '3|Heart',
//    '4|Club',
//]));

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


