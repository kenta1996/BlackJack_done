<?php

namespace BlackJack5;

require_once(__DIR__ . '/BlackJackGame.php');
require_once(__DIR__ . '/PlayerAction.php');
require_once(__DIR__ . '/PlayerPcAction.php');
require_once(__DIR__ . '/DoubleDown.php');

class Action
{
    public const BUST_NUMBER = 22;
    public const YES = 'y';
    public const NO = 'n';
    public const DOUBLE_DOWN = 'd';

    private const ADD_CARD_NUMBER = 1;
    private const TWO_TIMES = 2;
    private int $cnt = 0;
    /** @var array<mixed> */
    private array $playersData = [];

    public function __construct(private Call $call)
    {
    }

    /**
     * @param array<mixed> $players
     * @param int $playerMoney
     * @return void
     */
    public function decideBetMoney(array $players, int $playerMoney): void
    {
        $betMoney = 0;
        foreach ($players as $user) {
            $name = $user->getName();
            if ($name !== BlackJackGame::DEALER) {
                $switchUser = $this->getNextAction($name);
                $betMoney = $switchUser->decideBetMoney($this->call, $playerMoney, $name);
                $user->addBetMoney($betMoney, $playerMoney);
            }
        }
    }

    /**
     * @param Deck $deck
     * @param array<mixed> $players
     * @return void
     */
    public function nextAction(Deck $deck, array $players): void
    {
        $this->playersData = $players;
        while (true) {
            foreach ($this->playersData as $key => $user) {
                $this->cnt++;
                if ($this->checkDealerOrNot($user) || count($this->playersData) === 1) {
                    $user->hand->calcTotalNumber();
                    $totalPoint = $user->hand->getTotalPoint();
                    $name = $user->getName();
                    $this->call->scoreCall($totalPoint, $name);

                    //ここでプレイヤー特有のアクションへ移行
                    $switchUser = $this->getNextAction($name);
                    $answer = $switchUser->getNextActionAnswer($this->call, $totalPoint, $this->cnt);
                    $this->checkAnswer($user, $deck, $answer, $key);
                }
            }
            if (count($this->playersData) === 0) {
                break;
            }
        }
    }

    private function checkDealerOrNot(User $user): bool
    {
        return $user->getName() !== BlackJackGame::DEALER;
    }

    /**
     * @param string $name
     * @return mixed
     */
    private function getNextAction(string $name)
    {
        if ($name === BlackJackGame::YOU) {
            return new PlayerAction();
        }
        return new PlayerPcAction();
    }

    private function checkAnswer(User $user, Deck $deck, string $answer, int $key): void
    {
        if ($answer === self::NO) {
            unset($this->playersData[$key]);
            return;
        } elseif ($answer === self::DOUBLE_DOWN && $this->cnt === 1) {
            $rule = new DoubleDown();
            $rule->play($user, $deck, self::ADD_CARD_NUMBER);
            unset($this->playersData[$key]);
            return;
        } elseif ($answer === self::YES) {
            $user->addCard($deck, self::ADD_CARD_NUMBER);
            return;
        }
    }

    /**
     * @param array<mixed> $players
     */
    public function decideWinner(array $players): void
    {
        $result = BlackJackGame::DEALER;
        $dealerTotalPoint = $this->getDealerPoint($players);
        foreach ($players as $user) {
            if ($this->checkDealerOrNot($user)) {
                $totalPoint = $user->hand->getTotalPoint();
                $name = $user->getName();
                if ($totalPoint >= self::BUST_NUMBER) {
                    $result = BlackJackGame::DEALER;
                } elseif ($dealerTotalPoint >= self::BUST_NUMBER) {
                    $result = $name;
                } elseif ($totalPoint === $dealerTotalPoint) {
                    $result = BlackJackGame::DRAW;
                } elseif ($totalPoint > $dealerTotalPoint) {
                    $result = $name;
                }
                $this->call->pointCall($name, $totalPoint, $dealerTotalPoint);
                $this->call->resultCall($result);

                //ルールごとにアクションを変える
                $doubleDown = $user->getDoubleDown();
                if ($doubleDown) {
                    $rule = new DoubleDown();
                    $rule->finalCall($user, $result);
                    continue;
                }
                $this->calcMoney($user, $name, $result);
            }
        }
    }

    private function calcMoney(User $user, string $name, string $result): void
    {
        $betMoney = $user->money->getBetMoney();
        $money = $user->money->getMoney();
        if ($name === $result) {
            $totalMoney = $money + ($betMoney * self::TWO_TIMES);
            $user->money->addMoney($totalMoney);
            $this->call->moneyCall($name, $totalMoney, $betMoney);
            return;
        } elseif ($result == BlackJackGame::DRAW) {
            $totalMoney = $money + $betMoney;
            $user->money->addMoney($totalMoney);
            $this->call->moneyCall($name, $totalMoney, $betMoney);
            return;
        }
        $totalMoney = $money;
        $user->money->addMoney($totalMoney);
        $this->call->moneyCall($name, $totalMoney, $betMoney);
        return;
    }

    /**
     * @param array<mixed> $players
     */
    private function getDealerPoint(array $players): int
    {
        $dealerTotalPoint = 0;
        foreach ($players as $user) {
            if ($user->getName() === BlackJackGame::DEALER) {
                $dealerTotalPoint = $user->hand->getTotalPoint();
            }
        }
        return $dealerTotalPoint;
    }
}
