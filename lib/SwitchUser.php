<?php

namespace BlackJack5;

interface SwitchUser
{
    public function decideBetMoney(Call $call, int $playerMoney, string $name): int;
    public function getNextActionAnswer(Call $call, int $totalPoint, int $cnt): string;
}
