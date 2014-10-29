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
    public function AddUser($email, $password, $full_name)
    {
            $this->db_handle->query("INSERT INTO users (email, password, full_name) VALUES (:email, :password, :full_name)");
            $this->db_handle->bind(':email',$email);
            $this->db_handle->bind(':password',$password);
            $this->db_handle->bind(':full_name',$full_name);
            $this->db_handle->execute();
    }

    public function login($email, $password)
    {
            $this->db_handle->query("SELECT * FROM users WHERE email = :email AND password =:password");
            $this->db_handle->bind(':email',$email);
            $this->db_handle->bind(':password',$password);
            $user_data = $this->db_handle->resultset();
            return $user_data;
    }

    public function logout()
    {

    }

}