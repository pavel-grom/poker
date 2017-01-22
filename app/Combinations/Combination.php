<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Combinations;

/**
 * Description of Combination
 *
 * @author m1x
 */
class Combination
{
    
    public $data;
    
    public function __construct($tableCards, $playersCards)
    {
        $this->data = $this->getCombination($tableCards, $playersCards);
    }
   
    static public function getPrioritiesCounts($cards, $comb)
    {
        foreach ($cards as $card) {
            $priorities[] = $card->priority;
        }
        $priorities_counts = array_count_values($priorities);
        foreach ($priorities_counts as $card=>$count) {
            if ($count == 2) {
                $pairs[] = $card;
            } elseif ($count == 3) {
                $sets[] = $card;
            } elseif ($count == 4) {
                $quads[] = $card;
            } 
        }
        if ($comb == 'pair') {
            return isset($pairs) && count($pairs) == 1 ? $pairs : false;
        } elseif ($comb == 'twoPairs') {
            if (isset($pairs) && count($pairs) > 1) {
                if (count($pairs) > 2) {
                    unset($pairs[array_search(min($pairs), $pairs)]);
                }
                return $pairs;
            } else {
                return false;
            }
            
        } elseif ($comb == 'set') {
            if (isset($sets)) {
                return $sets;
            } else {
                return false;
            }
        } elseif ($comb == 'quad') {
            return $quads ?? false;
        }
    }
    
    static public function isPair($tableCards, $playersCards)
    {
        $cards = self::MergeAndSortCards($tableCards, $playersCards);
        
        $pairs = self::getPrioritiesCounts($cards, 'pair');
        if (!$pairs) return false;
        foreach ($cards as $key=>$card) {
            if (in_array($card->priority, $pairs)) {
                $pair_cards[] = $card;
            }
        }
        $pair_priority = $pair_cards[0]->priority;
        if (!empty($playersCards)) {
            foreach ($playersCards as $card) {
                if ($card->priority != $pair_priority) {
                    $kicker = $card;
                } else {
                    $pairCard = $card;
                }
            }
            if (!isset($pairCard)) {
                $playersCards = self::MergeAndSortCards([], $playersCards);
                $kicker = $playersCards[1];
                $secondKicker = $playersCards[0];
                return new Pair($pair_cards, $kicker, $secondKicker);
            }
            if (isset($kicker)) {
                return new Pair($pair_cards, $kicker);
            } else {
                return new Pair($pair_cards);
            }
            
        } else {
            foreach ($tableCards as $k => $card) {
                if ($card->priority == $pair_priority) {
                    unset($tableCards[$k]);
                }
            }
            $tableCards = self::MergeAndSortCards($tableCards, []);
            $kicker = $tableCards[2];
            $secondKicker = $tableCards[1];
            return new Pair($pair_cards, $kicker, $secondKicker);
        }
            
    }
    
    static public function isSet($tableCards, $playersCards)
    {
        $cards = self::MergeAndSortCards($tableCards, $playersCards);
        $sets = self::getPrioritiesCounts($cards, 'set');
        
        if (!$sets) return false;
        if (count($sets) > 1) {
            foreach ($cards as $key=>$card) {
                if (in_array($card->priority, $sets)) {
                    $sets_cards[] = $card;
                }
            }
            unset($sets_cards[0]);
            $sets_cards = array_values($sets_cards);
            return new FullHouse($sets_cards);
        }
        
        foreach ($cards as $key=>$card) {
            if (in_array($card->priority, $sets)) {
                $sets_cards[] = $card;
            }
        }
        
        if (!empty($playersCards)) {
            $playersSetsCards = [];
            foreach ($playersCards as $card) {
                if ($card->priority == $sets[0]) {
                    $playersSetsCards[] = $card;
                }
            }
            if (count($playersSetsCards) == 1) {
                foreach ($playersCards as $card) {
                    if ($card->priority != $playersSetsCards[0]->priority) {
                        $kicker = $card;
                    }
                }
                return new Set($sets_cards, $kicker);
            } elseif (count($playersSetsCards) == 2) {
                return new Set($sets_cards);
            } else {
                $playersCards = self::MergeAndSortCards([], $playersCards);
                $kicker = $playersCards[1];
                $secondKicker = $playersCards[0];
                return new Set($sets_cards, $kicker, $secondKicker);
            }
        } else {
            $kickers = [];
            foreach ($tableCards as $card) {
                if ($card->priority != $sets[0]) {
                    $kickers[] = $card;
                } 
            }
            $kickers = self::MergeAndSortCards([], $kickers);
            return new Set($sets_cards, $kickers[1], $kickers[0]);
        }
    }
    
    static public function isQuad($tableCards, $playersCards)
    {
        $cards = self::MergeAndSortCards($tableCards, $playersCards);
        $quads = self::getPrioritiesCounts($cards, 'quad');
        if (!$quads) return false;
        foreach ($cards as $key=>$card) {
            if (in_array($card->priority, $quads)) {
                $quads_cards[] = $card;
            }
        }
        
        if (!empty($playersCards)) {
            $playersQuadsCards = [];
            foreach ($playersCards as $card) {
                if ($card->priority == $quads[0]) {
                    $playersQuadsCards[] = $card;
                }
            }
            if (count($playersQuadsCards) == 1) {
                foreach ($playersCards as $card) {
                    if ($card->priority != $playersQuadsCards[0]->priority) {
                        $kicker = $card;
                    }
                }
                return new Quad($quads_cards, $kicker);
            } elseif (count($playersQuadsCards) == 2) {
                return new Quad($quads_cards);
            } else {
                $playersCards = self::MergeAndSortCards([], $playersCards);
                $kicker = $playersCards[1];
                return new Quad($quads_cards, $kicker);
            }
        } else {
            $kickers = [];
            foreach ($tableCards as $card) {
                if ($card->priority != $quads[0]) {
                    $kicker = $card;
                } 
            }
            return new Quad($quads_cards, $kicker);
        }
    }
    
    static public function isTwoPairs($tableCards, $playersCards)
    {
        $cards = self::MergeAndSortCards($tableCards, $playersCards);
        $pairs = self::getPrioritiesCounts($cards, 'twoPairs');
        if (!$pairs) return false;
        
        foreach ($cards as $key=>$card) {
            if (in_array($card->priority, $pairs)) {
                $pairs_cards[] = $card;
            }
        }
        
        if (!empty($playersCards)) {
            $playersPairsCards = [];
            foreach ($playersCards as $card) {
                if (in_array($card->priority, $pairs)) {
                    $playersPairsCards[] = $card;
                }
            }
            
            if (count($playersPairsCards) == 1) {
                foreach ($playersCards as $card) {
                    if ($card->priority != $playersPairsCards[0]->priority) {
                        $kicker = $card;
                    }
                }
                
                return new TwoPair($pairs_cards, $kicker);
            } elseif (count($playersPairsCards) == 2) {
                return new TwoPair($pairs_cards);
            } else {
                $playersCards = self::MergeAndSortCards([], $playersCards);
                $kicker = $playersCards[1];
                return new TwoPair($pairs_cards, $kicker);
            }
        } else {
            foreach ($cards as $card) {
                if (!in_array($card->priority, $pairs)) {
                    $kicker = $card;
                }
            }
            return new TwoPair($pairs_cards, $kicker);
        }
    }
    
    
    static public function isStraight($tableCards, $playersCards)
    {
        $cards = self::MergeAndSortCards($tableCards, $playersCards);
        if (count($cards) < 5) return false;
        foreach ($cards as $key => $card) {
            if (isset($cards[$key+1])) {
                if ($cards[$key]->priority == $cards[$key+1]->priority) {
                    unset($cards[$key]);
                }
            }
        }
        $cards = array_values($cards);
        // dd($cards);
        foreach ([5, 6, 7] as $count) {
            if (count($cards) == $count) {
                // dd($count);
                if (isset($cards[$count-5]) &&$cards[$count-1]->priority - $cards[$count-5]->priority == 4) {
                    $straight_cards = array_slice($cards, $count-5, 5);
                } elseif (isset($cards[$count-6]) && $cards[$count-2]->priority - $cards[$count-6]->priority == 4) {
                    $straight_cards = array_slice($cards, $count-6, 5);
                } elseif (isset($cards[$count-7]) && $cards[$count-3]->priority - $cards[$count-7]->priority == 4) {
                    // dd('sdsad');
                    $straight_cards = array_slice($cards, $count-7, 5);
                } elseif ($cards[0]->priority == 1
                    && $cards[1]->priority == 2
                    && $cards[2]->priority == 3
                    && $cards[3]->priority == 4
                    && $cards[count($cards)-1]->priority == 13) {
                    $straight_cards = array_merge([$cards[count($cards)-1]], array_slice($cards, 0, 4));
                }
            }
        }
        if (isset($straight_cards)) {
            return new Straight($straight_cards);
        } 
        return false;
    }
    
    static public function isFlush($tableCards, $playersCards)
    {
        $cards = self::MergeAndSortCards($tableCards, $playersCards);
        foreach ($cards as $card) {
            $suits[] = $card->suit;
        }
        $array_count_values = array_count_values($suits);
        // dd(max($array_count_values));
        if (max($array_count_values) >= 5) {
            $flush_suit = array_search(max($array_count_values), $array_count_values);
            // dd($flush_suit);
            $flush_cards = array_filter($cards, function($card) use ($flush_suit) {
                return $card->suit == $flush_suit;
            });
            $flush_cards = self::MergeAndSortCards($flush_cards, []);
            if (count($flush_cards) == 6) {
                unset($flush_cards[0]);
            } elseif (count($flush_cards) == 7) {
                unset($flush_cards[0]);
                unset($flush_cards[1]);
            }
            $flush_cards = array_values($flush_cards);
            return new Flush($flush_cards);
        } else {
            return false;
        }
        
    }
    
    static public function isStraightFlush($tableCards, $playersCards)
    {
        $cards = self::MergeAndSortCards($tableCards, $playersCards);
        $flush = self::isFlush($tableCards, $playersCards);
        if (!$flush) return false; 
        $flush->cards = array_values($flush->cards);
        $straight = self::isStraight($flush->cards, []);
        if ($straight && $flush) {
            if ($straight->cards == $flush->cards) {
                return new StraightFlush($flush->cards);
            }
            return false;
        }
        return false;
    }
    
    static public function isRoyalFlush($tableCards, $playersCards)
    {
        $cards = self::MergeAndSortCards($tableCards, $playersCards);
        $straightFlush = self::isStraightFlush($tableCards, $playersCards);
        if (!$straightFlush) return false;
        if ($straightFlush->cards[4]->priority == 13) {
            return new RoyalFlush($straightFlush->cards);
        }
        return false;
    }
    
    static public function isFullHouse($tableCards, $playersCards)
    {
        $cards = self::MergeAndSortCards($tableCards, $playersCards);
        $pair = self::isPair($tableCards, $playersCards);
        $set = self::isSet($tableCards, $playersCards);
        $twoPairs = self::isTwoPairs($tableCards, $playersCards);
        if ($pair && $set) {
            return new FullHouse(array_merge($pair->cards, $set->cards));
        } elseif ($twoPairs && $set) {
            $twoPairs->cards = array_slice($twoPairs->cards, 2, 2); 
            return new FullHouse(array_merge($twoPairs->cards, $set->cards));
        } else {
            return false;
        }
    }
    
    static public function isHighCard($tableCards, $playersCards)
    {
        $cards = self::MergeAndSortCards($tableCards, $playersCards);
        
        
        if (!empty($playersCards)) {
            $highCard = $cards[6];
            $playersCards = self::MergeAndSortCards([], $playersCards);
            $highCardOfPlayer = $playersCards[1];
            $kicker = $playersCards[0];
            
            $combCards = $cards;
            unset($combCards[0]);
            unset($combCards[1]);
            $combCards = array_values($combCards);
            if ($highCard->priority == $highCardOfPlayer->priority) {
                return new HighCard($highCard, $kicker, null, $combCards);
            } else {
                return new HighCard($highCard, $highCardOfPlayer, $kicker, $combCards);
            }
            
        } else {
            $tableCards = self::MergeAndSortCards($tableCards, []);
            $highCard = $tableCards[4];
            $kicker = $tableCards[3];
            $secondKicker = $tableCards[2];
            return new HighCard($highCard, $kicker, $secondKicker, $tableCards);
        }
    }
    
    static public function MergeAndSortCards($tableCards, $playersCards)
    {
        $cards = array_merge($tableCards, $playersCards);
        usort($cards, function($a, $b){
            if ($a->priority == $b->priority) {
                return 0;
            }
            return ($a->priority < $b->priority) ? -1 : 1;
        });
        return $cards;
    }
    
    static public function getCombination($tableCards, $playersCards)
    {
//        $cards = array_merge($tableCards, $playersCards);
//        usort($cards, function($a, $b){
//            if ($a->priority == $b->priority) {
//                return 0;
//            }
//            return ($a->priority < $b->priority) ? -1 : 1;
//        });
        if ($return = self::isRoyalFlush($tableCards, $playersCards)) {
            return $return;
        } 
        if ($return = self::isStraightFlush($tableCards, $playersCards)) {
            return $return;
        }
        if ($return = self::isQuad($tableCards, $playersCards)) {
           return $return;
        }
        if ($return = self::isFullHouse($tableCards, $playersCards)) {
            return $return;
        }
        if ($return = self::isFlush($tableCards, $playersCards)) {
            return $return;
        } 
        if ($return = self::isStraight($tableCards, $playersCards)) {
            return $return;
        }
        if ($return = self::isSet($tableCards, $playersCards)) {
            return $return;
        }
        if ($return = self::isTwoPairs($tableCards, $playersCards)) {
            return $return;
        }
        if ($return = self::isPair($tableCards, $playersCards)) {
            return $return;
        }
        return self::isHighCard($tableCards, $playersCards);
    }
}
