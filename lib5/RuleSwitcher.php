<?php

namespace BlackJack5;

interface RuleSwitcher
{
    public function play(User $user, Deck $deck, int $drawNum): void;
}
