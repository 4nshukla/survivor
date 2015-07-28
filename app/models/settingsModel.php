<?php
namespace app\models;

use core\database;

class settingsModel
{
    private $db_handle;
    public function __construct()
    {
        $this->db_handle = new database();
    }

    public function getSettings()
    {
        $this->db_handle->query("SELECT * FROM settings");
        return $this->db_handle->resultset();

    }
}