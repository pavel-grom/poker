<?php
/**
 * Created by PhpStorm.
 * User: m1x
 * Date: 019 19.10.18
 * Time: 17:09
 */

namespace Pagrom\Poker;


use Pagrom\Poker\Exceptions\GameLogicException;
use Pagrom\Poker\Interfaces\CombinationInterface;
use Pagrom\Poker\Interfaces\HasKickerInterface;
use Pagrom\Poker\Interfaces\HasTwoKickersInterface;
use Pagrom\Poker\Interfaces\OnePriorityOrientedCombinationInterface;
use Pagrom\Poker\Interfaces\SuitOrientedCombinationInterface;
use Pagrom\Poker\Interfaces\TwoPriorityOrientedCombinationInterface;

class PokerHelper
{
    /**
     * @var array
     * */
    private $config;

    /**
     * @var array
     * */
    private $cardsPrioritiesMap;

    /**
     * @var array
     * */
    private $cardsSuitsMap;

    /**
     * @var array
     * */
    private $cardsPrioritiesMapFlip;

    /**
     * @var array
     * */
    private $cardsSuitsMapFlip;

    /**
     * PokerHelper constructor.
     * @param array|null $config
     */
    public function __construct(?array $config = null)
    {
        $this->config = $config ?? require_once __DIR__ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';
        $this->cardsPrioritiesMap = $this->config['cards_priorities_map'];
        $this->cardsSuitsMap = $this->config['cards_suites_map'];
        $this->cardsPrioritiesMapFlip = array_flip($this->config['cards_priorities_map']);
        $this->cardsSuitsMapFlip = array_flip($this->config['cards_suites_map']);
    }

    /**
     * See named params in config.php
     *
     * @param string $priority
     * @param string $suit
     * @return array
     */
    public function getCardParamsByNamedParams(string $priority, string $suit): array
    {
        if (!isset($this->cardsPrioritiesMapFlip[$priority], $this->cardsSuitsMapFlip[$suit])) {
            throw new GameLogicException('Unknown named card params - ' . $priority . ' ' . $suit);
        }

        return [$this->cardsPrioritiesMapFlip[$priority], $this->cardsSuitsMapFlip[$suit]];
    }

    /**
     * @param int $priority
     * @return string
     */
    public function getNamedPriority(int $priority): string
    {
        return $this->cardsPrioritiesMap[$priority];
    }

    /**
     * @param string $priority
     * @return int
     */
    public function getPriorityByName(string $priority): int
    {
        return $this->cardsPrioritiesMapFlip[$priority];
    }

    /**
     * @param int $suit
     * @return string
     */
    public function getNamedSuit(int $suit): string
    {
        return $this->cardsSuitsMap[$suit];
    }

    /**
     * @param string $suit
     * @return int
     */
    public function getSuitByName(string $suit): int
    {
        return $this->cardsSuitsMapFlip[$suit];
    }

    /**
     * Get card name
     * See card_naming in config
     *
     * @param Card $card
     * @return string
     */
    public function getCardName(Card $card): string
    {
        $cardNaming = $this->config['card_naming'];
        $placeholders = [
            ':priority',
            ':suit',
        ];
        $cardParams = [
            $this->cardsPrioritiesMap[$card->getPriority()],
            $this->cardsSuitsMap[$card->getSuit()],
        ];

        return str_replace($placeholders, $cardParams, $cardNaming);
    }

    /**
     * @param CombinationInterface $combination
     * @param bool $needKicker
     * @param bool $needSecondKicker
     * @return array
     */
    public function getCombinationData(CombinationInterface $combination, bool $needKicker, bool $needSecondKicker): array
    {
        $combinationClass = get_class($combination);

        $data = [];

        $data['combination_name'] = $this->config['combinations'][$combinationClass]['name'];

        $combinationText = $this->config['combinations'][$combinationClass]['text'];
        $combinationSortedCardsNames = $combination->getSortedCards()->values()->map(function(Card $card){
            return $this->getCardName($card);
        });

        $combinationText = str_replace(':combination_name', $data['combination_name'], $combinationText);

        foreach ($combinationSortedCardsNames as $k => $cardName) {
            $cardKey = $k + 1;
            $combinationText = str_replace(':card_' . $cardKey, $cardName, $combinationText);
        }

        if ($combination instanceof OnePriorityOrientedCombinationInterface) {
            $combinationText = str_replace(
                ':priority_1',
                $this->getNamedPriority($combination->getPriority()),
                $combinationText
            );
        }

        if ($combination instanceof TwoPriorityOrientedCombinationInterface) {
            $combinationText = str_replace(
                ':priority_2',
                $this->getNamedPriority($combination->getSecondPriority()),
                $combinationText
            );
        }

        if ($combination instanceof SuitOrientedCombinationInterface) {
            $combinationText = str_replace(
                ':suit',
                $this->getNamedSuit($combination->getSuit()),
                $combinationText
            );
        }

        $data['combination_text'] = $combinationText;

        $kickersText = '';

        if ($needKicker) {
            if ($combination instanceof HasKickerInterface) {
                $kicker = $combination->getKicker();
                if ($kicker) {
                    $kickerName = $this->getCardName($kicker);
                    $kickerText = $this->config['combinations'][$combinationClass]['text_kicker'];
                    $kickerText = str_replace(
                        ':kicker',
                        $kickerName,
                        $kickerText
                    );
                    $kickersText = $kickerText;
                    if ($needSecondKicker && $combination instanceof HasTwoKickersInterface) {
                        $secondKicker = $combination->getSecondKicker();
                        if ($secondKicker) {
                            $secondKickerName = $this->getCardName($secondKicker);
                            $secondKickerText = $this->config['combinations'][$combinationClass]['text_second_kicker'];
                            $secondKickerText = str_replace(
                                ':kicker',
                                $kickerName,
                                $secondKickerText
                            );
                            $secondKickerText = str_replace(
                                ':second_kicker',
                                $secondKickerName,
                                $secondKickerText
                            );
                            $kickersText = $secondKickerText;
                        }
                    }
                }
            }
        }

        $data['combination_text']  = str_replace(':kickers_text', $kickersText, $data['combination_text']);

        return $data;
    }
}