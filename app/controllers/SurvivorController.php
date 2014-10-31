<?php
namespace app\controllers;

use app\models\userModel;
use app\models\ScoreModel;

class SurvivorController
{
    public function __construct()
    {

    }

    public function index()
    {
        $user_model = new userModel();
        $user_model->loginCheck();

        $scores = new ScoreModel();
        $this_week = $scores->CurrentScores();
        foreach($this_week as $score)
        {
            echo $score['away_team']." @ ".$score['home_team']."<br/>";
        }
    }
}