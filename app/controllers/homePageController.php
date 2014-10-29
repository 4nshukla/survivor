<?php

namespace app\controllers;

use app\models\userModel;
use core\helpers\twigFactory;

class homePageController
{
    private $twig;
    public function __construct()
    {

    }

    public function index($data = null)
    {

        $this->twig = twigFactory::getTwig();
        // load the form template
        $template = $this->twig->loadTemplate('homePage.twig');

        // data
        $index_data = array('title' => 'Paste It');
        if($data == null)
        {
            $data = array ('one' => 'one');
        }
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
                var_dump($user_data);
            }
        }
    }
}