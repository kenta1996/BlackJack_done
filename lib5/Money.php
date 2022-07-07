<?php

namespace BlackJack5;

class Money
{
    private int $playerMoney = 0;
    private int $betMoney = 0;

    public function addBetMoney(int $betMoney, int $playerMoney): void
    {
        $this->playerMoney = $playerMoney - $betMoney;
        $this->betMoney = $betMoney;
    }

    public function addMoney(int $playerMoney): void
    {
        $this->playerMoney = $playerMoney;
    }

    public function getBetMoney(): int
    {
        return $this->betMoney;
    }

    public function getMoney(): int
    {
        return $this->playerMoney;
    }
}
