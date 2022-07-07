<?php

namespace BlackJack5;

require_once('Deck.php');
require_once('Call.php');
require_once('User.php');
require_once('Action.php');

class BlackJackGame
{
    public const YOU = 'you';
    public const DRAW = 'draw';
    public const DEALER = 'dealer';

    private Deck $deck;
    private Call $call;
    private Action $action;
    private const FIRST_DRAW_NUM = 2;
    private int $playerMoney = 1000;
    /** @var array<mixed> */
    private array $players;

    public function __construct(object ...$players)
    {
        $this->players = $players;
        $this->deck = new Deck();
        $this->call = new Call();
        $this->action = new Action($this->call);
    }

    public function start(): void
    {
        $this->call->startCall();
        $this->action->decideBetMoney($this->players, $this->playerMoney);

        foreach ($this->players as $user) {
            $user->drawCards($this->deck, self::FIRST_DRAW_NUM);
        }

        $this->action->nextAction($this->deck, $this->players);

        //結果発表
        $this->action->decideWinner($this->players);
        $this->call->endCall();
    }
}
