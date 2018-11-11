<?php

use Pagrom\Poker\Card;
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

$table = new Table(new \Pagrom\Poker\GameTypes\Omaha());

$dean = new Player('Dean');
$sam = new Player('Sam');

$table->addPlayer($dean)->addPlayer($sam);

// deal cards manually
//$table->dealCardsByPattern($dean, $pokerHelper->getCardPatternByNamedPatternArray([
//    'A|Spade',
//    '5|Diamond',
//]));
//
//$table->dealCardsByPattern($sam, $pokerHelper->getCardPatternByNamedPatternArray([
//    '6|Diamond',
//    '5|Club',
//]));
//
//$table->dealCardsByPattern($table, $pokerHelper->getCardPatternByNamedPatternArray([
//    '3|Club',
//    'K|Spade',
//    'Q|Club',
//    '2|Diamond',
//    '4|Club',
//]));

$winners = $table->dealCards()
    ->determineCombinations()
    ->determineWinners()
    ->getWinners();

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
    dump($pokerHelper->getCombinationData($winner->getCombination(), $table->getWinnerDeterminant()));
}
