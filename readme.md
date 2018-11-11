Poker
=====

A PHP-based poker library capable of hand calculations, determine winning hand and preparing hands data.
Supports Texas Hold'em and Omaha(by contribute of [Andrei Karepin](https://github.com/shiziksama)) game types.

Install
-------

```
composer require pagrom/poker
```

Usage
-----

```php
use Pagrom\Poker\Card;
use Pagrom\Poker\Combination\WinnerDeterminant;
use Pagrom\Poker\Player;
use Pagrom\Poker\PokerHelper;
use Pagrom\Poker\Table;
use Pagrom\Poker\GameTypes\Holdem;

$pokerHelper = new PokerHelper();

$table = new Table(new Holdem);

$dean = new Player('Dean');
$sam = new Player('Sam');

$table->addPlayer($dean)->addPlayer($sam);

$winners = $table->dealCards()
    ->determineCombinations()
    ->determineWinners()
    ->getWinners();
```

Configuration
-------------

See src/config/config.php
For using custom config:
```php
$pokerHelper = new PokerHelper($customConfig);
```

Placeholders will be replaced with their values:
* :priority - card priority
* :priority_* - card priorities ordered by desc
* :suit - card suit
* :card_* - cards names, ordered by priority desc
* :kicker - first kicker
* :second_kicker - second kicker

Manually dealing cards
----------------------

```php
$dean = $table->getPlayer('Dean');
$sam = $table->getPlayer('Sam');

$table->dealCard($dean, $pokerHelper->getPriorityByName('Q'), $pokerHelper->getSuitByName('Spade'));
$table->dealCard($dean, $pokerHelper->getPriorityByName('A'), $pokerHelper->getSuitByName('Spade'));

$table->dealCard($sam, $pokerHelper->getPriorityByName('4'), $pokerHelper->getSuitByName('Spade'));
$table->dealCard($sam, $pokerHelper->getPriorityByName('7'), $pokerHelper->getSuitByName('Club'));

$table->dealCard($table, $pokerHelper->getPriorityByName('5'), $pokerHelper->getSuitByName('Heart'));
$table->dealCard($table, $pokerHelper->getPriorityByName('2'), $pokerHelper->getSuitByName('Spade'));
$table->dealCard($table, $pokerHelper->getPriorityByName('2'), $pokerHelper->getSuitByName('Diamond'));
$table->dealCard($table, $pokerHelper->getPriorityByName('3'), $pokerHelper->getSuitByName('Heart'));
$table->dealCard($table, $pokerHelper->getPriorityByName('4'), $pokerHelper->getSuitByName('Club'));
```

Use custom player instance
-----------------------

Custom player class should implements PlayerInterface.
Traits HasCardsTrait and HasCombinationTrait can help.

```php
use Pagrom\Poker\Interfaces\PlayerInterface;
use Pagrom\Poker\Traits\HasCardsTrait;
use Pagrom\Poker\Traits\HasCombinationTrait;

class CustomPlayer implements PlayerInterface
{
    use HasCardsTrait, HasCombinationTrait;
    
    /**
     * @var string $name
     */
    private $name;
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}

$table->addPlayer($customPlayer);
```

Custom randomizer for dealing cards
-----------------------------------

```php
$randomizerCallback = function(array $cardsKeys): int {
    return $cardsKeys[array_rand($cardsKeys)];
}

$table = new Table(Holdem,$randomizerCallback);
```

Get hand data
-------------

```php
$handData = $pokerHelper->getCombinationData($winner->getCombination(), $table->getWinnerDeterminant());
```