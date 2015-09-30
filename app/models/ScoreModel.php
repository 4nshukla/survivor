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
        $this->db_handle->query("SELECT weekly_games.*, t1.`name` as away_team_name, t2.`name` as home_team_name FROM weekly_games
                                 RIGHT JOIN teams t1 ON
                                 weekly_games.away_team = t1.short_name
                                 RIGHT JOIN teams t2 ON
                                 weekly_games.home_team = t2.short_name
                                 WHERE week = (SELECT week FROM weekly_games ORDER BY week DESC limit 1)");
        return $this->db_handle->resultset();
    }

    public function getCurrentWeekGame($team)
    {
        $this->db_handle->query("SELECT * FROM weekly_games WHERE (home_team = '".$team."' OR away_team = '".$team."') AND week =".$_SESSION['current_week']);
        return $this->db_handle->Single();
    }
}