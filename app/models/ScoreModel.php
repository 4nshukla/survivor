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
}