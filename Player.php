<?php

/**
 * Class Player
 */
class Player
{
    private $name;
    private $totalScore = 0;
    private $roundScore = 0;

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getTotalScore()
    {
        return $this->totalScore;
    }

    /**
     * @return mixed
     */
    public function getRoundScore()
    {
        return $this->roundScore;
    }

    /**
     * @param mixed $roundScore
     */
    public function addToRoundScore($roundScore)
    {
        $this->roundScore += $roundScore;
    }

    /**
     * Updates the Players Total Score
     * and sets the round back to 0
     */
    public function updateTotalScore()
    {
        $this->totalScore = $this->totalScore + $this->roundScore;
        $this->roundScore = 0;
    }
}