<?php

/*error reporting*/
error_reporting(E_ALL);
session_start();
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
echo '<link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon">';
require_once "vendor/autoload.php";
use app\controllers\homePageController;
use app\controllers\SignUpController;
use app\controllers\SurvivorController;
use app\crons\ScoreStrip;
use core\helpers\errorController;

if ($_SERVER['REQUEST_URI'] == "/score-strip")
{
    $score_strip = new ScoreStrip();
    $score_strip->WeeklyGameInsert();
}


if ($_SERVER['REQUEST_URI'] == "/sign-up")
{
    $login_controller = new SignUpController();
    if(!empty($_POST))
    {
        $login_controller->signup();
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

if ($_SERVER['REQUEST_URI'] == "/survivor")
{
    $survivor_controller = new SurvivorController();
    $survivor_controller->index();
}


if ($_SERVER['REQUEST_URI'] != "/")
    $homepage = new homePageController();

