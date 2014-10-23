<?php
namespace app\models;
use core\database;

class userModel extends database
{
    private $db_handle;
    public function __construct()
    {
        $this->db_handle = new database();
    }

    public function loginCheck()
    {/*
        $dbh = new database();
        $dbh->query("SELECT * FROM users");
        var_dump($dbh->resultset());
*/
    }

    /**
     * @param $email
     * @param $password
     * @param $full_name
     */
    public function addUser($email, $password, $full_name)
    {
            $this->db_handle->query("INSERT INTO users (email, password, full_name) VALUES (:email, :password, :full_name)");
            $this->db_handle->bind(':email',$email);
            $this->db_handle->bind(':password',$password);
            $this->db_handle->bind(':full_name',$full_name);
            $this->db_handle->execute();
    }

    public function login()
    {

    }

    public function logout()
    {

    }

}