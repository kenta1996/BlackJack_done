<?php

namespace BlackJack5;

require_once(__DIR__ . '/RuleSwitcher.php');
require_once(__DIR__ . '/DoubleDownCall.php');

class DoubleDown implements RuleSwitcher
{
    private const TWO_TIMES = 2;
    private const ZERO = 0;
    public DoubleDownCall $doubleDownCall;

    public function __construct()
    {
        $this->doubleDownCall = new DoubleDownCall();
    }
    public function play(User $user, Deck $deck, int $drawNum): void
    {
        $this->doubleDownCall->doubleDownCall();
        $user->addCard($deck, $drawNum);
        $user->addDoubleDown();
        $user->hand->calcTotalNumber();
    }

    public function finalCall(User $user, string $result): void
    {
        $name = $user->getName();
        $betMoney = $user->money->getBetMoney();
        $doubleBetMoney = $betMoney * self::TWO_TIMES;
        $money = $user->money->getMoney();
        $this->doubleDownCall->moneyCall($name, $money, $betMoney);
        if ($name === $result) {
            $totalMoney = $money + $doubleBetMoney + $betMoney;
            $user->money->addMoney($totalMoney);
            $this->doubleDownCall->winnerCall($name, $totalMoney, $betMoney, $doubleBetMoney);
            return;
        } elseif ($result == BlackJackGame::DRAW) {
            $totalMoney = $betMoney + $money;
            $user->money->addMoney($totalMoney);
            $this->doubleDownCall->drawCall($name, $totalMoney);
            return;
        }
        $totalMoney = $money - $doubleBetMoney;
        if ($totalMoney < self::ZERO) {
            $totalMoney = self::ZERO;
        }
        $user->money->addMoney($totalMoney);
        $this->doubleDownCall->loserCall($name, $totalMoney, $betMoney, $doubleBetMoney);
        return;
    }
}
