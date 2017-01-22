<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

use App\Combinations\Combination;
/**
 * Description of Table
 *
 * @author m1x
 */
class Table
{
    private $cards;
    public  $players;
    public  $tableCards;
    public  $combination;
    public  $inGame = true;
    public  $winners;
    
    public function __construct()
    {
        foreach (range(1, 13) as $priority) {
            foreach (range(1, 4) as $suit) {
                $this->cards[] = new Card($priority, $suit);
            }
        }
    }
    
    public function getRandomCards($cardsCount)
    {
        $playersCards = [];
        for ($i = 1; $i <= $cardsCount; $i++) {
            $randomCard = array_rand($this->cards, 1);
            $playersCards[$randomCard] = $this->cards[$randomCard];
            unset($this->cards[$randomCard]);
            unset($randomCard);
        }
        return $playersCards;
    }
    
    public function dealTheCards()
    {
        foreach ($this->players as $player) {
            $player->cards = $this->getRandomCards(2);
        }
        $this->tableCards = $this->getRandomCards(5);
    }
    
    public function addPlayer(Player $player)
    {
        $this->players[$player->name] = $player;
    }
    
    public function addPlayers(array $players)
    {
        foreach ($players as $player) {
            if ($player instanceof Player) {
                $this->players[$player->name] = $player;
            } else {
                throw new \Exception('Player must be instance of Player class');
            }
        }
    }
    
    public function computeCombinations()
    {
        foreach ($this->players as $player) {
            $player->combination = new Combination($this->tableCards, $player->cards);
        }
        $this->combination = new Combination($this->tableCards, []);
    }
    
    public function getWinner()
    {
        $weights = [];
        foreach ($this->players as $player) {
            $weights[$player->name] = $player->combination->data->combinationWeight;
        }
        $weights['table'] = $this->combination->data->combinationWeight;
        
        $maxWeight = max($weights);
        foreach ($weights as $k => $weight) {
            if ($weight != $maxWeight) {
                if ($k == 'table') {
                    $this->inGame = false;
                } else {
                    $this->players[$k]->inGame = false;
                }
                unset($weights[$k]);
            }
        }
        
        if (count($weights) == 1) {
            foreach ($weights as $name => $weight) {
                if ($name == 'table') {
                    $this->winners['table'] = [
                        'combination' => $this->combination->data,
                        'winString' => "Winner are the table with {$this->combination->data->getName()}",
                        'winnerName' => 'table'
                    ];
                    return;
                } else {
                    $this->winners[$this->players[$name]->name] = [
                        'combination' => $this->players[$name]->combination->data,
                        'winString' => "Winner is {$this->players[$name]->name} with {$this->players[$name]->combination->data->getName()}",
                        'winnerName' => $this->players[$name]->name
                    ];
                    return;
                }
                
            }
        }
        $totalWeights = [];
        foreach ($this->players as $player) {
            if ($player->inGame === false) {
                continue;
            }
            $totalWeights[$player->name] = $player->combination->data->totalWeight;
        }
        
        if ($this->inGame === true) {
            $totalWeights['table'] = $this->combination->data->totalWeight;
        }
        
        $maxCombId = round(array_values($totalWeights)[0]);
        
        $firstsNumbers = [];
        $secondsNumbers = [];
        $thirdsNumbers = [];
        $foursNumbers = [];
        $fivesNumbers = [];
        foreach ($totalWeights as $name => $totalWeight) {
            $firstsNumbers[$name] = substr($totalWeight, 2, 2);
            $secondsNumbers[$name] = substr($totalWeight, 4, 2);
            $thirdsNumbers[$name] = substr($totalWeight, 6, 2);
            $foursNumbers[$name] = substr($totalWeight, 8, 2);
            $fivesNumbers[$name] = substr($totalWeight, 10, 2);
        }
        
        $maxFirstNumbers = max($firstsNumbers);
        
        foreach ($firstsNumbers as $k => $card) {
            if ($card != $maxFirstNumbers) {
                if ($k == 'table') {
                    $this->inGame = false;
                } else {
                    $this->players[$k]->inGame = false;
                }
                unset($firstsNumbers[$k]);
                unset($secondsNumbers[$k]);
                unset($thirdsNumbers[$k]);
                unset($foursNumbers[$k]);
                unset($fivesNumbers[$k]);
            }
        }
        
        $maxSecondNumbers = max($secondsNumbers);
        
        foreach ($secondsNumbers as $k => $card) {
            if ($card != $maxSecondNumbers) {
                if ($k == 'table') {
                    $this->inGame = false;
                } else {
                    $this->players[$k]->inGame = false;
                }
                unset($secondsNumbers[$k]);
                unset($thirdsNumbers[$k]);
                unset($foursNumbers[$k]);
                unset($fivesNumbers[$k]);
            }
        }
        
        $maxThirdNumbers = max($thirdsNumbers);
        
        foreach ($thirdsNumbers as $k => $card) {
            if ($card != $maxThirdNumbers) {
                if ($k == 'table') {
                    $this->inGame = false;
                } else {
                    $this->players[$k]->inGame = false;
                }
                unset($thirdsNumbers[$k]);
                unset($foursNumbers[$k]);
                unset($fivesNumbers[$k]);
            }
        }
        
        if (in_array($maxCombId, [1, 2, 4])) {
            if (count($firstsNumbers) == 1) {
                foreach ($firstsNumbers as $name => $card) {
                    if ($name == 'table') {
                        $this->winners['table'] = [
                            'combination' => $this->combination->data,
                            'winString' => "Winner are the table with {$this->combination->data->getName()}",
                            'winnerName' => 'table'
                        ];
                        return;
                    } else {
                        $this->winners[$this->players[$name]->name] = [
                            'combination' => $this->players[$name]->combination->data,
                            'winString' => "Winner is {$this->players[$name]->name} with {$this->players[$name]->combination->data->getName()}",
                            'winnerName' => $this->players[$name]->name
                        ];
                        return;
                    }
                    
                }
            }
            
            if (count($secondsNumbers) == 1) {
                foreach ($secondsNumbers as $name => $kicker) {
                    if ($name == 'table') {
                        $this->winners['table'] = [
                            'combination' => $this->combination->data,
                            'winString' => "Winner are the table with {$this->combination->data->getName()} and with kicker {$this->combination->data->getKicker()}",
                            'winnerName' => 'table'
                        ];
                        return;
                    } else {
                        $this->winners[$this->players[$name]->name] = [
                            'combination' => $this->players[$name]->combination->data,
                            'winString' => "Winner is {$this->players[$name]->name} with {$this->players[$name]->combination->data->getName()} and with kicker {$this->players[$name]->combination->data->getKicker()}",
                            'winnerName' => $this->players[$name]->name
                        ];
                        return;
                    }
                }
            }

            if (count($thirdsNumbers) == 1) {
                foreach ($thirdsNumbers as $name => $card) {
                    if ($name == 'table') {
                        $this->winners['table'] = [
                            'combination' => $this->combination->data,
                            'winString' => "Winner are the table with {$this->combination->data->getName()} and with second kicker {$this->combination->data->getSecondKicker()}",
                            'winnerName' => 'table'
                        ];
                        return;
                    } else {
                        $this->winners[$this->players[$name]->name] = [
                            'combination' => $this->players[$name]->combination->data,
                            'winString' => "Winner is {$this->players[$name]->name} with {$this->players[$name]->combination->data->getName()} and with second kicker {$this->players[$name]->combination->data->getSecondKicker()}",
                            'winnerName' => $this->players[$name]->name
                        ];
                        return;
                    }
                }
            }

            foreach ($thirdsNumbers as $name => $card) {
                if ($name == 'table') {
                    continue;
                }
                $this->winners[$this->players[$name]->name] = [
                    'combination' => $this->players[$name]->combination->data,
                    'winString' => "{$this->players[$name]->name} with {$this->players[$name]->combination->data->getName()}",
                    'winnerName' => $this->players[$name]->name
                ];
            }
        } elseif ($maxCombId == 3) {
            if (count($firstsNumbers) == 1) {
                foreach ($firstsNumbers as $name => $card) {
                    if ($name == 'table') {
                        $this->winners['table'] = [
                            'combination' => $this->combination->data,
                            'winString' => "Winner are the table with {$this->combination->data->getName()}",
                            'winnerName' => 'table'
                        ];
                        return;
                    } else {
                        $this->winners[$this->players[$name]->name] = [
                            'combination' => $this->players[$name]->combination->data,
                            'winString' => "Winner is {$this->players[$name]->name} with {$this->players[$name]->combination->data->getName()}",
                            'winnerName' => $this->players[$name]->name
                        ];
                        return;
                    }
                }
            }
            
            if (count($secondsNumbers) == 1) {
                foreach ($secondsNumbers as $name => $card) {
                    if ($name == 'table') {
                        $this->winners['table'] = [
                            'combination' => $this->combination->data,
                            'winString' => "Winner are the table with {$this->combination->data->getName()}",
                            'winnerName' => 'table'
                        ];
                        return;
                    } else {
                        $this->winners[$this->players[$name]->name] = [
                            'combination' => $this->players[$name]->combination->data,
                            'winString' => "Winner is {$this->players[$name]->name} with {$this->players[$name]->combination->data->getName()}",
                            'winnerName' => $this->players[$name]->name
                        ];
                        return;
                    }
                }
            }
            
            if (count($thirdsNumbers) == 1) {
                foreach ($thirdsNumbers as $name => $card) {
                    if ($name == 'table') {
                        $this->winners['table'] = [
                            'combination' => $this->combination->data,
                            'winString' => "Winner are the table with {$this->combination->data->getName()} and with kicker {$this->combination->data->getKicker()}",
                            'winnerName' => 'table'
                        ];
                        return;
                    } else {
                        $this->winners[$this->players[$name]->name] = [
                            'combination' => $this->players[$name]->combination->data,
                            'winString' => "Winner is {$this->players[$name]->name} with {$this->players[$name]->combination->data->getName()} and with kicker {$this->players[$name]->combination->data->getKicker()}",
                            'winnerName' => $this->players[$name]->name
                        ];
                        return;
                    }
                }
            }
            foreach ($thirdsNumbers as $name => $card) {
                if ($name == 'table') {
                    continue;
                }
                $this->winners[$this->players[$name]->name] = [
                    'combination' => $this->players[$name]->combination->data,
                    'winString' => "{$this->players[$name]->name} with {$this->players[$name]->combination->data->getName()}",
                    'winnerName' => $this->players[$name]->name
                ];
            }
        } elseif ($maxCombId == 8) {
            if (count($firstsNumbers) == 1) {
                foreach ($firstsNumbers as $name => $card) {
                    if ($name == 'table') {
                        $this->winners['table'] = [
                            'combination' => $this->combination->data,
                            'winString' => "Winner are the table with {$this->combination->data->getName()}",
                            'winnerName' => 'table'
                        ];
                        return;
                    } else {
                        $this->winners[$this->players[$name]->name] = [
                            'combination' => $this->players[$name]->combination->data,
                            'winString' => "Winner is {$this->players[$name]->name} with {$this->players[$name]->combination->data->getName()}",
                            'winnerName' => $this->players[$name]->name
                        ];
                        return;
                    }
                }
            }
            
            if (count($secondsNumbers) == 1) {
                foreach ($secondsNumbers as $name => $card) {
                    if ($name == 'table') {
                        $this->winners['table'] = [
                            'combination' => $this->combination->data,
                            'winString' => "Winner are the table with {$this->combination->data->getName()} and with kicker {$this->combination->data->getKicker()}",
                            'winnerName' => 'table'
                        ];
                        return;
                    } else {
                        $this->winners[$this->players[$name]->name] = [
                            'combination' => $this->players[$name]->combination->data,
                            'winString' => "Winner is {$this->players[$name]->name} with {$this->players[$name]->combination->data->getName()} and with kicker {$this->players[$name]->combination->data->getKicker()}",
                            'winnerName' => $this->players[$name]->name
                        ];
                        return;
                    }
                }
            }
            
            foreach ($secondsNumbers as $name => $card) {
                if ($name == 'table') {
                    continue;
                }
                $this->winners[$this->players[$name]->name] = [
                    'combination' => $this->players[$name]->combination->data,
                    'winString' => "{$this->players[$name]->name} with {$this->players[$name]->combination->data->getName()}",
                    'winnerName' => $this->players[$name]->name
                ];
            }
        } elseif (in_array($maxCombId, [5, 9, 10])) {
            if (count($firstsNumbers) == 1) {
                foreach ($firstsNumbers as $name => $card) {
                    if ($name == 'table') {
                        $this->winners['table'] = [
                            'combination' => $this->combination->data,
                            'winString' => "Winner are the table with {$this->combination->data->getName()}",
                            'winnerName' => 'table'
                        ];
                        return;
                    } else {
                        $this->winners[$this->players[$name]->name] = [
                            'combination' => $this->players[$name]->combination->data,
                            'winString' => "Winner is {$this->players[$name]->name} with {$this->players[$name]->combination->data->getName()}",
                            'winnerName' => $this->players[$name]->name
                        ];
                        return;
                    }
                }
            }
            
            foreach ($firstsNumbers as $name => $numbers) {
                if ($name == 'table') {
                    continue;
                }
                $this->winners[$this->players[$name]->name] = [
                    'combination' => $this->players[$name]->combination->data,
                    'winString' => "{$this->players[$name]->name} with {$this->players[$name]->combination->data->getName()}",
                    'winnerName' => $this->players[$name]->name
                ];
            }
        } elseif ($maxCombId == 6) {
            
            $maxfourNumbers = max($foursNumbers);
        
            foreach ($foursNumbers as $k => $card) {
                if ($card != $maxfourNumbers) {
                    if ($k == 'table') {
                        $this->inGame = false;
                    } else {
                        $this->players[$k]->inGame = false;
                    }
                    unset($foursNumbers[$k]);
                    unset($fivesNumbers[$k]);
                }
            }
            
            $maxfiveNumbers = max($fivesNumbers);
        
            foreach ($fivesNumbers as $k => $card) {
                if ($card != $maxfiveNumbers) {
                    if ($k == 'table') {
                        $this->inGame = false;
                    } else {
                        $this->players[$k]->inGame = false;
                    }
                    unset($fivesNumbers[$k]);
                }
            }
            
            if (count($firstsNumbers) == 1) {
                foreach ($firstsNumbers as $name => $card) {
                    if ($name == 'table') {
                        $this->winners['table'] = [
                            'combination' => $this->combination->data,
                            'winString' => "Winner are the table with {$this->combination->data->getName()} with high card {$this->combination->data->getCard(4)->getName()}",
                            'winnerName' => 'table'
                        ];
                        return;
                    } else {
                        $this->winners[$this->players[$name]->name] = [
                            'combination' => $this->players[$name]->combination->data,
                            'winString' => "Winner is {$this->players[$name]->name} with {$this->players[$name]->combination->data->getName()} with high card {$this->players[$name]->combination->data->getCard(4)->getName()}",
                            'winnerName' => $this->players[$name]->name
                        ];
                        return;
                    }
                }
            }

            if (count($secondsNumbers) == 1) {
                foreach ($secondsNumbers as $name => $card) {
                    if ($name == 'table') {
                        $this->winners['table'] = [
                            'combination' => $this->combination->data,
                            'winString' => "Winner are the table with {$this->combination->data->getName()} with high card {$this->combination->data->getCard(3)->getName()}",
                            'winnerName' => 'table'
                        ];
                        return;
                    } else {
                        $this->winners[$this->players[$name]->name] = [
                            'combination' => $this->players[$name]->combination->data,
                            'winString' => "Winner is {$this->players[$name]->name} with {$this->players[$name]->combination->data->getName()} with high card {$this->players[$name]->combination->data->getCard(3)->getName()}",
                            'winnerName' => $this->players[$name]->name
                        ];
                        return;
                    }
                }
            }

            if (count($thirdsNumbers) == 1) {
                foreach ($thirdsNumbers as $name => $card) {
                    if ($name == 'table') {
                        $this->winners['table'] = [
                            'combination' => $this->combination->data,
                            'winString' => "Winner are the table with {$this->combination->data->getName()} with high card {$this->combination->data->getCard(2)->getName()}",
                            'winnerName' => 'table'
                        ];
                        return;
                    } else {
                        $this->winners[$this->players[$name]->name] = [
                            'combination' => $this->players[$name]->combination->data,
                            'winString' => "Winner is {$this->players[$name]->name} with {$this->players[$name]->combination->data->getName()} with high card {$this->players[$name]->combination->data->getCard(2)->getName()}",
                            'winnerName' => $this->players[$name]->name
                        ];
                        return;
                    }
                }
            }
            
            if (count($foursNumbers) == 1) {
                foreach ($foursNumbers as $name => $card) {
                    if ($name == 'table') {
                        $this->winners['table'] = [
                            'combination' => $this->combination->data,
                            'winString' => "Winner are the table with {$this->combination->data->getName()} with high card {$this->combination->data->getCard(1)->getName()}",
                            'winnerName' => 'table'
                        ];
                        return;
                    } else {
                        $this->winners[$this->players[$name]->name] = [
                            'combination' => $this->players[$name]->combination->data,
                            'winString' => "Winner is {$this->players[$name]->name} with {$this->players[$name]->combination->data->getName()} with high card {$this->players[$name]->combination->data->getCard(1)->getName()}",
                            'winnerName' => $this->players[$name]->name
                        ];
                        return;
                    }
                }
            }
            
            if (count($fivesNumbers) == 1) {
                foreach ($fivesNumbers as $name => $card) {
                    if ($name == 'table') {
                        $this->winners['table'] = [
                            'combination' => $this->combination->data,
                            'winString' => "Winner are the table with {$this->combination->data->getName()} with high card {$this->combination->data->getCard(0)->getName()}",
                            'winnerName' => 'table'
                        ];
                        return;
                    } else {
                        $this->winners[$this->players[$name]->name] = [
                            'combination' => $this->players[$name]->combination->data,
                            'winString' => "Winner is {$this->players[$name]->name} with {$this->players[$name]->combination->data->getName()} with high card {$this->players[$name]->combination->data->getCard(0)->getName()}",
                            'winnerName' => $this->players[$name]->name
                        ];
                        return;
                    }
                }
            }

            foreach ($firstsNumbers as $name => $card) {
                if ($name == 'table') {
                    continue;
                }
                $this->winners[$this->players[$name]->name] = [
                    'combination' => $this->players[$name]->combination->data,
                    'winString' => "{$this->players[$name]->name} with {$this->players[$name]->combination->data->getName()} with high card {$this->players[$name]->combination->data->getCard(1)}",
                    'winnerName' => $this->players[$name]->name
                ];
            }
        } elseif ($maxCombId == 7) {
            if (count($firstsNumbers) == 1) {
                foreach ($firstsNumbers as $name => $card) {
                    if ($name == 'table') {
                        $this->winners['table'] = [
                            'combination' => $this->combination->data,
                            'winString' => "Winner are the table with {$this->combination->data->getName()}",
                            'winnerName' => 'table'
                        ];
                        return;
                    } else {
                        $this->winners[$this->players[$name]->name] = [
                            'combination' => $this->players[$name]->combination->data,
                            'winString' => "Winner is {$this->players[$name]->name} with {$this->players[$name]->combination->data->getName()}",
                            'winnerName' => $this->players[$name]->name
                        ];
                        return;
                    }
                }
            }

            if (count($secondsNumbers) == 1) {
                foreach ($secondsNumbers as $name => $card) {
                    if ($name == 'table') {
                        $this->winners['table'] = [
                            'combination' => $this->combination->data,
                            'winString' => "Winner are the table with {$this->combination->data->getName()}",
                            'winnerName' => 'table'
                        ];
                        return;
                    } else {
                        $this->winners[$this->players[$name]->name] = [
                            'combination' => $this->players[$name]->combination->data,
                            'winString' => "Winner is {$this->players[$name]->name} with {$this->players[$name]->combination->data->getName()}",
                            'winnerName' => $this->players[$name]->name
                        ];
                        return;
                    }
                }
            }
            
            foreach ($firstsNumbers as $name => $card) {
                if ($name == 'table') {
                    continue;
                }
                $this->winners[$this->players[$name]->name] = [
                    'combination' => $this->players[$name]->combination->data,
                    'winString' => "{$this->players[$name]->name} with {$this->players[$name]->combination->data->getName()}",
                    'winnerName' => $this->players[$name]->name
                ];
            }
        }
    }
}
