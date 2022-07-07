<?php

namespace BlackJack5;

require_once('BlackJackGame.php');
require_once('User.php');

$player = new User('you');
$cp1 = new User('CP1');
$cp2 = new User('CP2');
$dealer = new User('dealer');
$game = new BlackJackGame($player, $cp1, $cp2, $dealer);
$game->start();
