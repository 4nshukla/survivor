<?php

/*error reporting*/
include_once "app/system/config.php";
session_start();
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/New_York');
echo '<link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon">';
require_once "vendor/autoload.php";
use app\controllers\homePageController;
use app\controllers\SignUpController;
use app\controllers\CertificationController;
use app\controllers\SurvivorController;
use app\crons\ScoreStrip;
use core\helpers\errorController;

if ($_SERVER['REQUEST_URI'] == "/score-strip")
{
    $score_strip = new ScoreStrip();
    $score_strip->WeeklyGameInsert();
}

if ($_SERVER['REQUEST_URI'] == "/logout")
{
    $homepage_controller = new homePageController();
    $homepage_controller->logout();
}

if($_SERVER['REQUEST_URI'] == "/certification")
{

    $certification_controller = new CertificationController();

    if(!empty($_POST))
    {
        $certification_controller->agree();
    }
    else
    {
        $certification_controller->index();
    }


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

if ($_SERVER['REQUEST_URI'] == "/report")
{
    $survivor_controller = new SurvivorController();
    $survivor_controller->report();
}


if ($_SERVER['REQUEST_URI'] != "/")
    $homepage = new homePageController();

