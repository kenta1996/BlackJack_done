<?php

namespace BlackJack5;

require_once('Action.php');

class Hand
{
    /** @var array<mixed>  */
    private array $hand = [];
    private int $totalPoint = 0;
    private int $cnt = 0;
    private const UPPERCASE_A = 'A';
    private const COUNT_ONE = 1;

    private const POINTS = [
        'A' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
        '8' => '8',
        '9' => '9',
        '10' => '10',
        'J' => '10',
        'Q' => '10',
        'K' => '10',
    ];

    private const SPECIAL_POINTS = [
        'A' => '11',
    ];

    public function addHand(Card $card): void
    {
        $this->hand[] = $card;
    }

    public function addTotalPoint(int $totalPoint): void
    {
        $this->totalPoint = $totalPoint;
    }

    public function getTotalPoint(): int
    {
        return $this->totalPoint;
    }

    public function calcTotalNumber(): void
    {
        $totalOutOfA = 0;

        foreach ($this->hand as $hand) {
            $number = $hand->getNumber();
            if ($number === self::UPPERCASE_A) {
                $this->cnt++;
                continue;
            }
            $totalOutOfA += self::POINTS[$number];
        }
        $totalPoint = $totalOutOfA;
        if ($this->cnt >= self::COUNT_ONE) {
            $totalPoint = $this->getBestPoints($this->cnt, $totalOutOfA);
        }
        $this->addTotalPoint($totalPoint);
    }

    private function getBestPoints(int $cnt, int $totalOutOfA): int
    {
        $sumTotalPoint = 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $sumTotalPoint = $totalOutOfA + self::SPECIAL_POINTS[self::UPPERCASE_A];
            if (Action::BUST_NUMBER <= $sumTotalPoint) {
                $sumTotalPoint += self::POINTS[self::UPPERCASE_A];
                $sumTotalPoint -= self::SPECIAL_POINTS[self::UPPERCASE_A];
            }
        }
        return $sumTotalPoint;
    }
}
