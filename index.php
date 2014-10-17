<?php

/*error reporting*/
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

require_once "vendor/autoload.php";
use app\controllers\homePageController;
use app\models\userModel;

//if not on home page or sign up, create a new user model
if ($_SERVER['REQUEST_URI'] != "/" && $_SERVER['REQUEST_URI'] != "/sign-up")
{
    $user_model = new userModel();
    $user_model->loginCheck();
}

if ($_SERVER['REQUEST_URI'] != "/")
    $homepage = new homePageController();

