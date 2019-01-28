<?php
include 'Game.php';

$players = ['Player1', 'Player2', 'Player3', 'Player4'];

$game = new Game($players, true);
$game->playGame();