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

    public function updateUserGameStatus()
    {
        $this->db_handle->query('SELECT site_value FROM settings WHERE site_key = "current_week"');
        $week_in_db = $this->db_handle->Single();

        $this->db_handle->query('SELECT * FROM users WHERE is_active = 1');
        $users = $this->db_handle->resultset();

        $previous_week = $week_in_db['site_value']-1;
        $this->db_handle->query('SELECT IF(winner = away_team, home_team, away_team) as loser FROM weekly_games WHERE week = '.$previous_week);
        $loser_teams_sub_array = $this->db_handle->resultset();

        $loser_teams = [];

        foreach($loser_teams_sub_array as $loser_team_sub_array)
        {
            $loser_teams[] = $loser_team_sub_array['loser'];
        }

        foreach ($users as $user) {
            $this->db_handle->query('SELECT id, team_picked FROM user_picks WHERE week_number = ' . $previous_week . ' AND user_id = ' . $user['id'] . ' ORDER BY id DESC LIMIT 1');
            $user_team_picked = $this->db_handle->resultset();

            if ( ! empty($user_team_picked)) {
                if (in_array($user_team_picked[0]['team_picked'], $loser_teams)) {
                    //if the pick lost
                    $this->db_handle->query("UPDATE user_picks SET does_move_on = 0 WHERE id = " . $user_team_picked[0]['id']);
                    $this->db_handle->execute();
                } else {
                    //if the pick won
                    $this->db_handle->query("UPDATE user_picks SET does_move_on = 1 WHERE id = " . $user_team_picked[0]['id']);
                    $this->db_handle->execute();
                }
            }
        }

    }

    public function WeeklyGameInsert()
    {
        $scores = file_get_contents('http://www.nfl.com/liveupdate/scorestrip/scorestrip.json');
        $scores = str_replace(',,' , ',"",', $scores);
        $scores = str_replace(',,' , ',"",', $scores);
        $scores = str_replace(',,' , ',"",', $scores);
        $scores = json_decode($scores);
        $scores =  (array) $scores;
        $week = substr($scores['ss'][0][12], 3);

        //update week to the feed week
        $this->db_handle->query("UPDATE settings SET site_value = :week WHERE site_key = 'current_week'");
        $this->db_handle->bind(':week',$week);
        $this->db_handle->execute();

        $this->db_handle->query("SELECT COUNT(*) FROM weekly_games WHERE week = :week");
        $this->db_handle->bind(':week',$week);
        $already_exists = $this->db_handle->RowCount();

        //if games for this week do not exists
        if($already_exists == 0)
        {
            //first update last week's user records
            $this->updateUserGameStatus();

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
                if($value[2] != "Pregame")
                {
                    var_dump($value);
                    $this->db_handle->query("UPDATE weekly_games SET away_team_score = :away_team_score,
                                                                     home_team_score = :home_team_score,
                                                                     quarter = :quarter,
                                                                     quarter_time_left = :quarter_time_left
                                                                 WHERE provider_id = $value[10]");
                    $this->db_handle->bind(':away_team_score',$value[5]);
                    $this->db_handle->bind(':home_team_score',$value[7]);
                    $this->db_handle->bind(':quarter',$value[2]);
                    $this->db_handle->bind(':quarter_time_left',$value[3]);
                    $this->db_handle->execute();
                }
            }
        }

        $this->db_handle->query("UPDATE weekly_games SET winner = IF (away_team_score > home_team_score, away_team, home_team) WHERE quarter = 'Final'");
        $this->db_handle->execute();

        $this->db_handle->query("UPDATE weekly_games SET loser = IF (away_team_score < home_team_score, away_team, home_team) WHERE quarter = 'Final'");
        $this->db_handle->execute();
    }

}