<?php

/*error reporting*/
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

require_once "vendor/autoload.php";
use app\controllers\homePageController;
use app\models\userModel;
use core\helpers\errorController;

echo '<link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon"> ';

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

