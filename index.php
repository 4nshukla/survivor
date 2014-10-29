<?php

/*error reporting*/
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
echo '<link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon">';
require_once "vendor/autoload.php";
use app\controllers\homePageController;
use app\controllers\loginController;
use app\models\userModel;
use core\helpers\errorController;


if ($_SERVER['REQUEST_URI'] == "/sign-up")
{
    $login_controller = new loginController();
    if(!empty($_POST))
    {
        $login_controller->SignUp();
    }
    else
    {
        $login_controller->index();
    }
}

if ($_SERVER['REQUEST_URI'] == "/")
{
    $homepage_controller = new homePageController();
    if(!empty($_POST))
    {
        $homepage_controller->login();
    }
    else
    {
        $homepage_controller->index();
    }
}

//if not on home page or sign up, create a new user model
if ($_SERVER['REQUEST_URI'] != "/" && $_SERVER['REQUEST_URI'] != "/sign-up")
{

    //$error_controller = new errorController();
    //$error_controller->show404();
    //$user_model = new userModel();
    //$user_model->addUser("nilesh4life@gmail.com","pass","Nilesh Shukla");
    $home_controller = new homePageController();
    $home_controller->index();
}

if ($_SERVER['REQUEST_URI'] != "/")
    $homepage = new homePageController();

