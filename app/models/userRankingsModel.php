<?php
namespace app\models;

use core\database;

class UserRankingsModel
{
    private $db_handle;
    public function __construct()
    {
        $this->db_handle = new database();
    }

    public function getCurrentRankings()
    {
        $this->db_handle->query("SELECT id, full_name, 'in' as `status` FROM users WHERE id NOT IN (SELECT DISTINCT user_id FROM user_picks WHERE does_move_on = 0)
                                  UNION ALL
                                 SELECT id, full_name, 'out' as `status` FROM users WHERE id IN (SELECT DISTINCT user_id FROM user_picks WHERE does_move_on = 0)
                                 ORDER BY `status` , `full_name` ");
        return $this->db_handle->resultset();
    }
}