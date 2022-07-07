<?php

namespace BlackJack5;

require_once(__DIR__ . '/BlackJackGame.php');

class DoubleDownCall
{

    public function lineCall(): void
    {
        echo '----------------------------------------------' . PHP_EOL;
    }

    public function doubleDownCall(): void
    {
        $this->lineCall();
        echo 'ダブルダウンを選択しました' . PHP_EOL;
    }

    public function moneyCall(string $name, int $money, int $betMoney): void
    {
        echo $name . 'の残金は' . $money . '円です。' . PHP_EOL;
        echo 'bet金額は' . $betMoney . '円です。' . PHP_EOL;
    }

    public function winnerCall(string $name, int $totalMoney, int $betMoney, int $doubleBetMoney): void
    {
        echo $name . 'はダブルダウンを選択していますので、掛け金' . $betMoney . 'の2倍(' . $doubleBetMoney . ')をもらえます。' . PHP_EOL;
        echo $name . 'の現在の残金は' . $totalMoney . '円になりました' . PHP_EOL;
    }

    public function drawCall(string $name, int $totalMoney): void
    {
        echo $name . 'の残金は' . $totalMoney . '円になりました' . PHP_EOL;
    }

    public function loserCall(string $name, int $totalMoney, int $betMoney, int $doubleBetMoney): void
    {
        echo $name . 'はダブルダウンを選択していますので、掛け金' . $betMoney . '円の2倍(' . $doubleBetMoney . '円)引かれます' . PHP_EOL;
        echo $name . 'の残金は' . $totalMoney . '円になりました' . PHP_EOL;
    }
}
