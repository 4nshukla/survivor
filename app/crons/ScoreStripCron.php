<?php
namespace app\crons;

use core\database;

class ScoreStrip
{
    private $db_handle;

    public function __construct()
    {
        $this->db_handle = new database();
    }

    public function WeeklyGameInsert()
    {
        $scores = file_get_contents('http://www.nfl.com/liveupdate/scorestrip/scorestrip.json');
        $scores = str_replace(',,' , ',"",', $scores);
        $scores = str_replace(',,' , ',"",', $scores);
        $scores = str_replace(',,' , ',"",', $scores);
        $scores = json_decode($scores);
        print_r($scores);
        $scores =  (array) $scores;
        $week = substr($scores['ss'][0][12], -1);

        $this->db_handle->query("SELECT COUNT(*) FROM weekly_games WHERE week = :week");
        $this->db_handle->bind(':week',$week);
        $already_exists = $this->db_handle->RowCount();

        if($already_exists == 0)
        {
            foreach($scores['ss'] as $value)
            {
                $this->db_handle->query("INSERT INTO weekly_games (provider_id, away_team, home_team, week, day, time) VALUES (:provider_id, :away_team, :home_team, :week, :day, :time)");
                $this->db_handle->bind(':away_team',$value[4]);
                $this->db_handle->bind(':home_team',$value[6]);
                $this->db_handle->bind(':week',$week);
                $this->db_handle->bind(':day',$value[0]);
                $this->db_handle->bind(':time',$value[1]);
                $this->db_handle->bind(':provider_id',$value[10]);
                $this->db_handle->execute();
            }
        }
        else
        {
            foreach($scores['ss'] as $value)
            {
                $this->db_handle->query("UPDATE weekly_games SET away_team_score = :away_team_score,
                                                                 home_team_score = :home_team_score
                                                             WHERE provider_team_id = $value[10]");
            }
        }

    }

}