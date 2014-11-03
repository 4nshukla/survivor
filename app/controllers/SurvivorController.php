<?php
namespace app\controllers;

use app\models\userModel;
use app\models\ScoreModel;
use core\helpers\twigFactory;

class SurvivorController
{
    private $twig;
    public function __construct()
    {

    }


    public function index()
    {
        $user_model = new userModel();
        $user_model->loginCheck();

        $scores = new ScoreModel();
        $this_week = $scores->CurrentScores();

        //var_dump($this_week);
        foreach($this_week as $key=>$value)
        {
            if(is_numeric($this_week[$key]['quarter']))
            {
                $this_week[$key]['quarter'] = "Quarter: ".$this_week[$key]['quarter'];
            }
            elseif($this_week[$key]['quarter'] != "Final" AND $this_week[$key]['quarter'] != "Half")
            {
                $this_week[$key]['quarter'] = strtoupper($this_week[$key]['day']. " AT " . $this_week[$key]['time']);
                $this_week[$key]['home_team_score'] = "--";
                $this_week[$key]['away_team_score'] = "--";
            }
        }

        $user_data['name'] =  $_SESSION['name'];
        $this->twig = twigFactory::getTwig();
        // load the form template
        $template = $this->twig->loadTemplate('Survivor.twig');
        // render and pass in the title at the same time
        echo $template->render(array('weekly_socres' => $this_week, 'user_data' => $user_data));
    }
}