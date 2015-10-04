<?php

namespace app\controllers;

use app\models\settingsModel;
use app\models\userModel;
use core\helpers\twigFactory;

class homePageController
{
    private $twig;
    private $enc_pass;
    private $method;
    public function __construct()
    {
        $this->method = 'aes128';
        $this->enc_pass = 'survivor';
    }

    public function index($data = null)
    {
        //if cookie is set, log them in
        if(!empty($_COOKIE['base']) AND is_numeric($this->__decrypt($_COOKIE['base'])))
        {
            $user = new userModel();
            $user_data = $user->getUserByID($this->__decrypt($_COOKIE['base']));
            $_SESSION['email'] = $user_data[0]['email'];
            $_SESSION['name'] = $user_data[0]['full_name'];
            $_SESSION['user_id'] = $user_data[0]['id'];
            setcookie('base', $this->__encrypt($_SESSION['user_id']), time() + 60 * 60 * 24 * 30);
            header( 'Location: /survivor' ) ;

        }
        //if not send user to login page
        $this->twig = twigFactory::getTwig();
        // load the form template
        $template = $this->twig->loadTemplate('homePage.twig');

        $index_data = [];
        if(!empty($data))
            $index_data = array_merge($index_data, $data);

        // render and pass in the title at the same time
        echo $template->render($index_data);
    }

    public function login()
    {
        $user = new userModel();
        if(!empty($_POST))
        {
            $user_data = $user->login($_POST['email'],$_POST['password']);
            if(empty($user_data[0]['full_name']))
            {
                $login_data = array("message" => "Incorrect Username or Password");
                $this->index($login_data);
            }
            else
            {
                $_SESSION['email'] = $user_data[0]['email'];
                $_SESSION['name'] = $user_data[0]['full_name'];
                $_SESSION['user_id'] = $user_data[0]['id'];
                //set cookie if keep me logged in is selected
                if($_POST['keep_logged_in'] == 'Yes')
                    setcookie('base', $this->__encrypt($_SESSION['user_id']), time() + 60 * 60 * 24 * 30);
                header( 'Location: /survivor' ) ;
            }
        }
    }

    private function __encrypt($string)
    {
        return openssl_encrypt ($string, $this->method, $this->enc_pass);
    }

    private function __decrypt($enc_string)
    {
        return openssl_decrypt($enc_string, $this->method, $this->enc_pass);
    }

    public function logout()
    {
        //delete session
        session_destroy();
        
        // unset cookies
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                setcookie($name, '', time()-1000);
                setcookie($name, '', time()-1000, '/');
            }
        }

        header( 'Location: /' ) ;
    }
}