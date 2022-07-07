<?php

namespace BlackJack5;

require_once('Deck.php');
require_once('Hand.php');
require_once('Money.php');

require_once('Call.php');
require_once('Action.php');

class User
{
    public Hand $hand;
    public Money $money;
    public Call $call;
    public Action $action;
    public bool $doubleDown = false;

    public function __construct(protected string $name)
    {
        $this->hand = new Hand();
        $this->money = new Money();
        $this->call = new Call();
        $this->action = new Action($this->call);
    }

    // public function decideBetMoney(int $playerMoney): void
    // {
    //     $betMoney = $this->action->decideBetMoney($playerMoney, $this->name);
    //     $this->addBetMoney($betMoney, $playerMoney);
    // }

    public function addBetMoney(int $betMoney, int $playerMoney): void
    {
        $this->money->addBetMoney($betMoney, $playerMoney);
    }

    public function drawCards(Deck $deck, int $drawNum): void
    {
        $cards = $deck->drawCards($drawNum);
        foreach ($cards as $card) {
            $this->addHand($card);
        }
        $this->call->firstCardsCall($cards, $this->name);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function addHand(Card $card): void
    {
        $this->hand->addHand($card);
    }

    public function addCard(Deck $deck, int $drawNum): void
    {
        $cards = $deck->drawCards($drawNum);
        foreach ($cards as $card) {
            $this->addHand($card);
        }
        $this->call->cardsCall($cards, $this->name);
    }

    public function getDoubleDown(): bool
    {
        return $this->doubleDown;
    }

    public function addDoubleDown(): void
    {
        $this->doubleDown = true;
    }
}
