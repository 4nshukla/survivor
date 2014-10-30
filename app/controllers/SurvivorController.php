<?php
namespace app\controllers;

use app\models\userModel;

class SurvivorController
{
    public function __construct()
    {

    }

    public function index()
    {
        $user_model = new userModel();
        $user_model->loginCheck();
    }
}