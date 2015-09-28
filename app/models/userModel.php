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
    {
        if (empty($_SESSION['user_id']))
        {
            header( 'Location: /' ) ;
        }
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
            $this->db_handle->query("SELECT * FROM users WHERE email = :email AND password =:password AND is_active = 1");
            $this->db_handle->bind(':email',$email);
            $this->db_handle->bind(':password',$password);
            $user_data = $this->db_handle->resultset();
            return $user_data;
    }


    public function getCurrentUserStatus($user_id = null)
    {
        $user_id =  ($user_id == null ? $_SESSION['user_id'] : $user_id);
        $this->db_handle->query("SELECT COUNT(*) as count FROM user_picks WHERE does_move_on = 0 AND user_id = ".$user_id);
        if ($this->db_handle->resultset()[0]['count'] > 0)
        {
            return 'out';
        }
        else
        {
            return 'in';
        }
    }

    public function getAllPreviousPicks($week_number)
    {
        //assuming the update only happens on last pick
        $this->db_handle->query("SELECT DISTINCT team_picked FROM user_picks WHERE user_id = ".$_SESSION['user_id']." AND does_move_on IN (1,0) AND week_number < ".$week_number);
        $previous_picks = [];
        foreach($this->db_handle->resultset() as $pick)
        {
            $previous_picks = array_merge($previous_picks, array($pick['team_picked']));
        }
        return $previous_picks;
    }

    public function checkIfCertified()
    {
        $query = "SELECT is_certified FROM users WHERE id = ".$_SESSION['user_id'];
        $this->db_handle->query($query);
        $response = $this->db_handle->Single();
        return $response['is_certified'];
    }

    public function makeCertified()
    {

        //check if user selected checkbox
        if($_POST['certified'] == 'yes')
        {
            $query = "UPDATE users SET is_certified = 1 WHERE id = ".$_SESSION['user_id'];
            $this->db_handle->query($query);
            $this->db_handle->execute();
        }
        else
        {
            header( 'Location: /certification?q=check' ) ;
        }
    }

}