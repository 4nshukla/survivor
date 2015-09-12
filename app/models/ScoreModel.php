<?php
namespace app\models;

use core\database;

class ScoreModel
{
    private $db_handle;
    public function __construct()
    {
        $this->db_handle = new database();
    }

    public function CurrentScores()
    {
        $this->db_handle->query("SELECT * FROM weekly_games WHERE week = (SELECT week FROM weekly_games ORDER BY week DESC limit 1)");
        return $this->db_handle->resultset();
    }

    public function getCurrentWeekGame($team)
    {
        $this->db_handle->query("SELECT * FROM weekly_games WHERE (home_team = '".$team."' OR away_team = '".$team."') AND week =".$_SESSION['current_week']);
        return $this->db_handle->Single();
    }
}