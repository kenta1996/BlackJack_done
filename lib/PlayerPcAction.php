<?php

namespace BlackJack5;

require_once('SwitchUser.php');
require_once('Action.php');

class PlayerPcAction implements SwitchUser
{
    private const STOP_NUMBER = 17;

    public function __construct()
    {
    }

    public function decideBetMoney(Call $call, int$playerMoney, string $name): int
    {
        $call->notBetMoneyCall($playerMoney, $name);
        return 0;
    }

    public function getNextActionAnswer(Call $call, int $totalPoint, int $cnt): string
    {
        $answer = Action::YES;
        if ($this->checkBustOrNot($totalPoint)) {
            $call->pcStopCall();
            $answer = Action::NO;
            return $answer;
        }
        return $answer;
    }

    private function checkBustOrNot(int $totalPoint): bool
    {
        return $totalPoint >= self::STOP_NUMBER;
    }
}
