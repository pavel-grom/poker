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
$dean = $table->getPlayer('Dean');
$sam = $table->getPlayer('Sam');

$table->dealCardsByPattern($dean, $pokerHelper->getCardPatternByNamedPatternArray([
    'A|Spade',
    'K|Diamond',
]));

$table->dealCardsByPattern($sam, $pokerHelper->getCardPatternByNamedPatternArray([
    'A|Diamond',
    'K|Club',
]));

$table->dealCardsByPattern($table, $pokerHelper->getCardPatternByNamedPatternArray([
    'A|Club',
    'J|Club',
    '10|Club',
    '8|Club',
    '6|Club',
]));

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

dump('Candidates:');
foreach ($winnerDeterminant->getCandidates() as $candidate) {
    dump($candidate->getName());
    dump($pokerHelper->getCombinationData($candidate->getCombination(), $winnerDeterminant));
}


