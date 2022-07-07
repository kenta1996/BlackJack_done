<?php

namespace BlackJack5;

require_once(__DIR__ . '/Card.php');

class Deck
{
    private const NUMBER = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];
    private const SUIT = ['ハート', 'スペード', 'ダイヤ', 'クラブ',];

    /**
     * @var array<mixed>
     */
    private array $hand = [];

    public function __construct()
    {
        foreach (self::SUIT as $suit) {
            foreach (self::NUMBER as $number) {
                $this->hand[] = new Card($suit, $number);
            }
        }
        shuffle($this->hand);
    }

    /**
     * @param int $drawNum
     * @return array<mixed>
     */
    public function drawCards(int $drawNum): array
    {
        $cards = array_splice($this->hand, 0, $drawNum);
        return $cards;
    }
}
