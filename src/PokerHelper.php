<?php

namespace Pagrom\Poker;


use Pagrom\Poker\Combination\CombinationDeterminant;
use Pagrom\Poker\Combination\WinnerDeterminant;
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
        $this->config = $config ?? require __DIR__ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';
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
     * @param WinnerDeterminant $winnerDeterminant
     * @return array
     */
    public function getCombinationData(CombinationInterface $combination, WinnerDeterminant $winnerDeterminant): array
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

        if ($firstPriorityText = $this->getFirstPriorityText($combination)) {
            $combinationText = str_replace(
                ':priority_1',
                $firstPriorityText,
                $combinationText
            );
        }

        if ($secondPriorityText = $this->getSecondPriorityText($combination)) {
            $combinationText = str_replace(
                ':priority_2',
                $secondPriorityText,
                $combinationText
            );
        }

        if ($suitText = $this->getSuitText($combination)) {
            $combinationText = str_replace(
                ':suit',
                $suitText,
                $combinationText
            );
        }

        $needKicker = $winnerDeterminant->isNeedKicker();
        $needSecondKicker = $winnerDeterminant->isNeedSecondKicker();

        $kickersText = $this->getKickersText($combination, $needKicker, $needSecondKicker);
        $combinationText = str_replace(':kickers_text', $kickersText, $combinationText);

        $data['combination_text'] = $combinationText;

        return $data;
    }

    /**
     * @param CombinationInterface $combination
     * @return null|string
     */
    public function getFirstPriorityText(CombinationInterface $combination): ?string
    {
        if (!($combination instanceof OnePriorityOrientedCombinationInterface)) {
            return null;
        }

        return $this->getNamedPriority($combination->getPriority());
    }

    /**
     * @param CombinationInterface $combination
     * @return null|string
     */
    public function getSecondPriorityText(CombinationInterface $combination): ?string
    {
        if (!($combination instanceof TwoPriorityOrientedCombinationInterface)) {
            return null;
        }

        return $this->getNamedPriority($combination->getSecondPriority());
    }

    /**
     * @param CombinationInterface $combination
     * @return null|string
     */
    public function getSuitText(CombinationInterface $combination): ?string
    {
        if (!($combination instanceof SuitOrientedCombinationInterface)) {
            return null;
        }

        return $this->getNamedSuit($combination->getSuit());
    }

    /**
     * @param CombinationInterface $combination
     * @param bool $needKicker
     * @param bool $needSecondKicker
     * @return string|null
     */
    public function getKickersText(CombinationInterface $combination, bool $needKicker, bool $needSecondKicker): string
    {
        if (
            !$needKicker
            || !($kickerText = $this->getFirstKickerText($combination))
        ) {
            return '';
        }

        if (
            !$needSecondKicker
            || !($secondKickerText = $this->getSecondKickerText($combination))
        ) {
            return $kickerText;
        }

        return $kickerText . $secondKickerText;
    }

    /**
     * @param CombinationInterface $combination
     * @return null|string
     */
    public function getFirstKickerText(CombinationInterface $combination): ?string
    {
        if (
            !($combination instanceof HasKickerInterface)
            || !($kicker = $combination->getKicker())
        ) {
            return null;
        }

        $combinationClass = get_class($combination);

        $kickerName = $this->getCardName($kicker);
        $kickerText = $this->config['combinations'][$combinationClass]['text_kicker'];

        return str_replace(
            ':kicker',
            $kickerName,
            $kickerText
        );
    }

    /**
     * @param CombinationInterface $combination
     * @return null|string
     */
    public function getSecondKickerText(CombinationInterface $combination): ?string
    {
        if (
            !($combination instanceof HasTwoKickersInterface)
            || !($secondKicker = $combination->getSecondKicker())
        ) {
            return null;
        }

        $combinationClass = get_class($combination);

        $secondKickerName = $this->getCardName($secondKicker);
        $secondKickerText = $this->config['combinations'][$combinationClass]['text_second_kicker'];

        return str_replace(
            ':second_kicker',
            $secondKickerName,
            $secondKickerText
        );
    }

    /**
     * @param string $namedPattern
     * @return string
     */
    public function getCardPatternByNamedPattern(string $namedPattern): string
    {
        [$priority, $suit] = explode('|', $namedPattern);

        return $this->getPriorityByName($priority) . '|' . $this->getSuitByName($suit);
    }

    /**
     * @param array $namedPatterns
     * @return array
     */
    public function getCardPatternByNamedPatternArray(array $namedPatterns): array
    {
        return array_map(function(string $pattern){
            return $this->getCardPatternByNamedPattern($pattern);
        }, $namedPatterns);
    }

    /**
     * @param Table $table
     */
    public function determineCombinations(Table $table): void
    {
        foreach ($table->getPlayers() as $player) {
            $playerCombinationDeterminant = $table->getCombinationDeterminant($table->getCards(), $player->getCards());
            $combination = $playerCombinationDeterminant->getCombination();
            $player->setCombination($combination);
        }
    }
}