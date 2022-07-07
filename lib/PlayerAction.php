<?php

namespace BlackJack5;

require_once(__DIR__ . '/SwitchUser.php');
require_once('Action.php');

class PlayerAction implements SwitchUser
{
    public Call $call;

    public function decideBetMoney(Call $call, int $playerMoney, string $name): int
    {
        $call->decideBetMoneyCall($playerMoney, $name);
        while (true) {
            $betMoney = trim(fgets(STDIN));
            if ($betMoney > $playerMoney) {
                $call->decideAgainBetMoneyCall($playerMoney);
                continue;
            }
            return (int) $betMoney;
        }
    }

    public function getNextActionAnswer(Call $call, int $totalPoint, int $cnt): string
    {
        $answer = Action::NO;
        if ($this->checkBustOrNot($totalPoint)) {
            $call->playerStopCall();
            $answer = Action::NO;
            return $answer;
        }
        $call->choiceCall($cnt);
        $answer = trim(fgets(STDIN));
        while (true) {
            if ($answer == Action::NO) {
                return $answer;
            } elseif ($answer == Action::YES) {
                return $answer;
            } elseif ($answer == Action::DOUBLE_DOWN && $cnt === 1) {
                $status = Action::DOUBLE_DOWN;
                return $status;
            }
            $call->choiceAgainCall($cnt);
            $answer = trim(fgets(STDIN));
        }
    }

    private function checkBustOrNot(int $totalPoint): bool
    {
        return $totalPoint >= Action::BUST_NUMBER;
    }
}
