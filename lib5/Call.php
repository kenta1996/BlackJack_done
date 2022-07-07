<?php

namespace BlackJack5;

require_once(__DIR__ . '/BlackJackGame.php');

class Call
{
    private const SECOND_CARD = 1;

    public function startCall(): void
    {
        echo  PHP_EOL;
        echo '---------------------開始---------------------' . PHP_EOL;
    }

    public function endCall(): void
    {
        echo '----------------------------------------------' . PHP_EOL;
        echo '---------------------終了---------------------' . PHP_EOL;
        echo  PHP_EOL;
    }

    public function lineCall(): void
    {
        echo '----------------------------------------------' . PHP_EOL;
    }

    public function decideBetMoneyCall(int $playerMoney, string $name): void
    {
        $this->lineCall();
        echo $name . 'の現在持っている金額は' . $playerMoney . 'です。' . PHP_EOL;
        echo 'いくらbetしますか？' . PHP_EOL;
    }

    public function decideAgainBetMoneyCall(int $playerMoney): void
    {
        echo $playerMoney . '以下でbetしてください' . PHP_EOL;
    }

    public function notBetMoneyCall(int $playerMoney, string $name): void
    {
        $this->lineCall();
        echo $name . 'の現在持っている金額は' . $playerMoney . 'です。' . PHP_EOL;
        echo 'PCのためbetできません' . PHP_EOL;
        $this->lineCall();
    }

    /**
     * @param array<mixed> $cards
     * @param string $name
     * @return void
     */
    public function firstCardsCall(array $cards, string $name): void
    {
        foreach ($cards as $num => $card) {
            if ($name == BlackJackGame::DEALER && $num == self::SECOND_CARD) {
                echo $name . 'の引いた2枚目のカードはわかりません' . PHP_EOL;
                continue;
            }
            echo $name . 'の引いたカードは' . $card->getSuit() . 'の' . $card->getNumber() . 'です。' . PHP_EOL;
        }
        $this->lineCall();
    }

    public function choiceCall(int $cnt): void
    {
        echo 'カードを引きますか？(y/n)' . PHP_EOL;
        if ($cnt === 1) {
            echo 'それともダブルプルダウンを選択しますか?(d)' . PHP_EOL;
        }
    }

    public function choiceAgainCall(int $cnt): void
    {
        echo 'y (続ける)か n (やめる)';
        if ($cnt === 1) {
            echo 'か d(ダブルダウン)' ;
        }
        echo 'を選択してください' . PHP_EOL;
    }

    public function playerStopCall(): void
    {
        echo 'ポイントは22以上でバーストです。' . PHP_EOL;
        $this->lineCall();
    }

    public function pcStopCall(): void
    {
        echo '17以上なのでstopします。' . PHP_EOL;
        $this->lineCall();
    }

    public function scoreCall(int $totalPoint, string $name): void
    {
        echo $name . 'の現在の得点は' . $totalPoint . 'です。' . PHP_EOL;
    }

    /**
     * @param array<mixed> $cards
     * @param string $name
     * @return void
     */
    public function cardsCall(array $cards, string $name): void
    {
        foreach ($cards as $card) {
            echo $name . 'の引いたカードは' . $card->getSuit() . 'の' . $card->getNumber() . 'です。' . PHP_EOL;
        }
        $this->lineCall();
    }

    public function pointCall(string $name, int $totalPoint, int $dealerTotalPoint): void
    {
        $this->lineCall();
        echo $name . 'の得点は' . $totalPoint . 'です。' . PHP_EOL;
        echo 'ディーラーの得点は' . $dealerTotalPoint . 'です。' . PHP_EOL;
    }

    public function resultCall(string $result): void
    {
        if ($result === BlackJackGame::DRAW) {
            echo '結果はドローです'. PHP_EOL;
            $this->lineCall();
            return;
        }
        echo $result . 'の勝ちです。' . PHP_EOL;
        $this->lineCall();
    }

    public function moneyCall(string $name, int $totalMoney, int $betMoney): void
    {
        echo $name . 'のbetした金額は' . $betMoney . '円でした' . PHP_EOL;
        echo $name . 'の現在の残金は' . $totalMoney . '円になりました' . PHP_EOL;
    }
}
