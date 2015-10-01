<?php
namespace app\models;

use core\database;

class userPicksModel
{
    private $db_handle;
    public function __construct()
    {
        $this->db_handle = new database();
    }

    public function getCurrentWeekPick()
    {
        $this->db_handle->query("SELECT * FROM user_picks WHERE week_number = ".$_SESSION['current_week']." AND user_id = ".$_SESSION['user_id']." ORDER BY id DESC LIMIT 1");
        return $this->db_handle->resultset();
    }

    public function getTotalPicksByTeam()
    {
        $sql = "SELECT COUNT(*) as count, team_picked FROM(
                SELECT t1.* FROM user_picks t1
                JOIN (SELECT id, user_id, MAX(id) as max_id FROM user_picks GROUP BY user_id) t2
                ON t1.user_id = t2.user_id AND t1.id = t2.max_id WHERE t1.week_number = ".$_SESSION['current_week'].") as t3 GROUP BY team_picked";
        $this->db_handle->query($sql);
        return $this->db_handle->resultset();
    }

    public function getCurrentWeekPicksAllUser()
    {
        $sql = "SELECT users.full_name, t1.team_picked FROM user_picks t1
                JOIN (SELECT id, user_id, MAX(id) as max_id FROM user_picks GROUP BY user_id) t2
                ON t1.user_id = t2.user_id AND t1.id = t2.max_id
                JOIN users ON users.id = t1.user_id
                WHERE t1.week_number = ".$_SESSION['current_week'];
        $this->db_handle->query($sql);
        return $this->db_handle->resultset();
    }
}