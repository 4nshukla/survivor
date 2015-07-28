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
}