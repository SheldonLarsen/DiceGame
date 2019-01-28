<?php
include 'Game.php';

//List of Player Names
$players = ['Player1', 'Player2', 'Player3', 'Player4'];

$game = new Game($players);
$game->playGame();