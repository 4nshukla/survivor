<?php
namespace app\controllers;

use app\models\userModel;
use app\models\ScoreModel;
use app\models\userPicksModel;
use app\models\UserRankingsModel;
use core\helpers\twigFactory;
use app\models\settingsModel;

class SurvivorController
{
    private $days_of_the_week = ['Sun'=>3, 'Mon'=>4, 'Tue'=>5, 'Wed'=> -1, 'Thu'=>0, 'Fri'=>1, 'Sat'=>2];
    private $twig;
    public function __construct()
    {

    }


    public function index()
    {

        $user_model = new userModel();
        $user_model->loginCheck();

        $is_certified = $user_model->checkIfCertified();
        if(!$is_certified)
        {
            header( 'Location: /certification' ) ;
        }

        //set current week
        $this->__setCurrentWeek();

        //pass user id to javascript
        echo "<script>
                var user_id = '$_SESSION[user_id]';
                var current_week = '$_SESSION[current_week]';
              </script>";

        $scores = new ScoreModel();
        $this_week = $scores->CurrentScores();

        $rankings_obj = new UserRankingsModel();
        $rankings = $rankings_obj->getCurrentRankings();

        //get current week pick
        $pick_obj = new userPicksModel();
        $pick_results = $pick_obj->getCurrentWeekPick();

        if($pick_results)
        {
        $team_picked = $pick_results[0]['team_picked'];
        $current_pick_game = $scores->getCurrentWeekGame($team_picked);
            if($current_pick_game)
            {
                //check if the game user picked has already begun or finished
                $game_remain_to_play = $this->__checkIFGameRemainsToPlay($current_pick_game);
                $user_data['picked_game_begin'] = ($game_remain_to_play == 1 ? 'no' : 'yes');
            }
        }




        //get current user status
        $user_model = new userModel();
        $status = $user_model->getCurrentUserStatus();
        $user_data['game_status'] = $status;

        //get all previous picks
        $previous_picks = $user_model->getAllPreviousPicks($_SESSION['current_week']);
        $user_data['previous_picks'] = $previous_picks;

        //get pick numbers for each team
        $team_pick_count = [];
        $total_picks_by_team = $pick_obj->getTotalPicksByTeam();
        foreach($total_picks_by_team as $team_pick)
        {
            $team_pick_count[$team_pick['team_picked']] = $team_pick['count'];
        }

        foreach($this_week as $key=>$value)
        {
            //check if the game is started/finished, if so make the dropdown disabled
            $this_week[$key]['game_remain'] = $this->__checkIFGameRemainsToPlay($value);

            if(is_numeric($this_week[$key]['quarter']))
            {
                $this_week[$key]['quarter'] = "Quarter: ".$this_week[$key]['quarter'];
            }
            elseif($this_week[$key]['quarter'] != "Final" AND $this_week[$key]['quarter'] != "Halftime")
            {
                $this_week[$key]['quarter'] = strtoupper($this_week[$key]['day']. " AT " . $this_week[$key]['time']);
                $this_week[$key]['home_team_score'] = "--";
                $this_week[$key]['away_team_score'] = "--";
            }
        }
        $javascript = ['survivor.js', 'slidebars.js'];

        $user_data['name'] =  $_SESSION['name'];
        $this->twig = twigFactory::getTwig();
        // load the form template
        $template = $this->twig->loadTemplate('Survivor.twig');

        // render and pass in the title at the same time
        echo $template->render(array('weekly_socres' => $this_week, 'user_data' => $user_data, 'js' => $javascript, 'team_picked' => $team_picked, 'rankings' => $rankings, 'team_pick_count' => $team_pick_count));
    }

    private function __checkIFGameRemainsToPlay($game_data)
    {
        $game_day = $game_data['day'];
        $current_day = date('D');

        if($this->days_of_the_week[$current_day] > $this->days_of_the_week[$game_day])
        {
            return 0;
        }

        elseif ($this->days_of_the_week[$current_day] == $this->days_of_the_week[$game_day])
        {
            //check time logic for same day
            $game_time = $game_data['time'];

            //if game time is greater than now, then the game is enabled to pick since it hasnt started yet
            if(strtotime($game_time) > strtotime("now"))
                return 1;
            else
                return 0;
        }
        return 1;
    }


    private function __setCurrentWeek()
    {
        $settings = new settingsModel();
        $settings_data = $settings->getSettings();
        foreach($settings_data as $setting)
        {
            if($setting['site_key'] == 'current_week')
                $_SESSION['current_week'] = $setting['site_value'];
        }
    }

    public function report()
    {
        $user_picks_model = new userPicksModel();
        echo "<pre>";
        print_r($user_picks_model->getCurrentWeekPicksAllUser());
        echo "</pre>";

    }
}