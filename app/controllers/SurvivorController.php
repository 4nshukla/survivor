<?php
namespace app\controllers;

use app\models\userModel;
use app\models\ScoreModel;
use app\models\userPicksModel;
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

        //pass user id to javascript
        echo "<script>
                var user_id = '$_SESSION[user_id]';
                var current_week = '$_SESSION[current_week]';
              </script>";

        $scores = new ScoreModel();
        $this_week = $scores->CurrentScores();

        //get current week pick
        $pick_obj = new userPicksModel();
        $pick_results = $pick_obj->getCurrentWeekPick();
        $team_picked = $pick_results[0]['team_picked'];



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

        $javascript = ['survivor.js'];

        $user_data['name'] =  $_SESSION['name'];
        $this->twig = twigFactory::getTwig();
        // load the form template
        $template = $this->twig->loadTemplate('Survivor.twig');
        // render and pass in the title at the same time
        echo $template->render(array('weekly_socres' => $this_week, 'user_data' => $user_data, 'js' => $javascript, 'team_picked' => $team_picked));
    }
}