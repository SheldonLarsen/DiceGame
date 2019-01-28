<?php
include 'Player.php';

class Game
{
    private $players;
    private $rounds = 4;
    private $dice = 5;


    /**
     * Game constructor.
     * @param $players
     */
    public function __construct($players)
    {
        $this->players = $players;
    }

    /**
     * This is the main function for the game
     */
    public function playGame()
    {
        $this->setup();

        //Loop for the Number of Rounds
        for ($round = 1; $round <= $this->rounds; $round++) {
            echo "\nRound {$round}\n";
            echo "----------------------------------\n";

            //Loop For Each Players Turn
            foreach ($this->players as $player) {
                echo "Player {$player->getName()}'s turn\n";

                //Loop until all dice have been selected
                $selectedDice = 0;
                do {
                    echo "Rolling...\n";
                    $roll = $this->rollDice($this->dice - $selectedDice);
                    $selected = $this->chooseDice($roll, $player);
                    $this->printSelectedDice($selected);
                    $selectedDice += count($selected);
                } while ($selectedDice < $this->dice);
            }
            $this->resetRound();
        }

        $this->totalScores();
    }

    /**
     * Randomizes the play order and then creates a player object for each player
     */
    private function setup()
    {
        //Randomize the Play Order
        shuffle($this->players);

        //Create each Player Obj
        foreach ($this->players as &$player) {
            $player = new Player($player);
        }
    }

    /**
     * Randomizes a given number of Dice Rolls
     * @param $numberToRoll
     * @return array
     */
    private function rollDice($numberToRoll)
    {
        $dice = [];
        for ($rolled = 0; $rolled < $numberToRoll; $rolled++) {
            $roll = rand(1, 6);
            $dice[] = $roll;
        }

        $this->printDice($dice);
        return $dice;
    }

    /**
     * This Does a ascii art print of the dice rolled
     * @param $dice
     */
    private function printDice($dice)
    {
        for ($row = 0; $row < 3; $row++) {
            foreach ($dice as $singleDice) {
                switch ($row) {
                    case 0:
                        echo "┏━━━┓";
                        break;

                    case 1:
                        echo "┃ {$singleDice} ┃";
                        break;

                    case 2:
                        echo "┗━━━┛";
                        break;
                }
            }
            echo "\n";
        }
    }

    /**
     * This is the basic algorithm to choose dice
     * It will select all 4s or if none are found,
     * Then it will select the dice with the lowest value
     * @param $dice
     * @param $player
     * @return array
     */
    private function chooseDice($dice, $player)
    {
        $selected = array_keys($dice, 4);
        if (!empty($selected)) {
            return $selected;
        } else {
            $value = min($dice);
            $player->addToRoundScore($value);
            return array(array_search($value, $dice));
        }

    }

    /**
     * This does ascii arrows under the dice
     * @param $selected
     */
    private function printSelectedDice($selected)
    {
        $location = 0;
        foreach ($selected as $entry) {
            echo str_repeat("     ", ($entry - $location));
            echo " ^^^ ";
            $location = $entry + 1;
        }
        echo "\n\n";
    }

    /**
     * This Totals the game scores then resets the round scores
     */
    private function resetRound()
    {
        foreach ($this->players as $player) {
            echo "{$player->getName()} Scored: {$player->getRoundScore()}\n";
            $player->updateTotalScore();
        }
    }

    /**
     * Prints the winner and all players score
     */
    private function totalScores()
    {
        echo "\n\n----------------------------------\n";
        foreach ($this->players as $player) {
            $score = $player->getTotalScore();
            if (!isset($winner) || $winner->getTotalScore() > $score) {
                $winner = $player;
            }

            echo "{$player->getName()}'s Total Score is: {$score}\n";
        }

        echo "\n\nAnd the Winner is....\n";
        echo "{$winner->getName()} with a score of {$winner->getTotalScore()} \n\n";
    }
}