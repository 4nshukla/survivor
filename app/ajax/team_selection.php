<?php

require_once('../../core/database.class.php');
require_once('../models/userModel.php');


$user_obj = new \app\models\userModel();
$user_status =  $user_obj->getCurrentUserStatus($_POST['user_id']);

//checking if user is eligible to play because anyone can disable javascript and click radio button as a hack
if ($user_status == 'in')
{
    insertUserPicks();
}
else
{
    echo "Something doesn't look correct. Please contact Nilesh Shukla";
}






function insertUserPicks()
{
    $user_id = $_POST['user_id'];
    $team_picked = $_POST['team_picked'];
    $current_week = $_POST['current_week'];

    $db_handle = new \core\database();

    $db_handle->query("INSERT INTO user_picks (user_id, week_number, team_picked) VALUES (:user_id, :week_number, :team_picked)");
    $db_handle->bind(':user_id',$user_id);
    $db_handle->bind(':week_number',$current_week);
    $db_handle->bind(':team_picked',$team_picked);
    if ($db_handle->insert() > 0)
    {
        echo __random_funny_lines($team_picked);
    }
    else
    {
        echo "The site encountered an error. Please contact Nilesh Shukla";
    }
}



function __random_funny_lines($team_picked)
{
        $funny_lines = [
            'ha ha, you really think team_picked can win this week?',
            'Good luck bud. I am rooting for team_picked as well',
            'Booya. Way to go. team_picked looks strong',
            'Poor you. There is no way team_picked is winning this week',
            'Go team_picked!',
            'I will give you a pizza slice is team_picked wins this week',
        ];

    $random_lines = str_replace("team_picked", $team_picked, $funny_lines);
    $random_line = array_rand($random_lines, 1);
    return $random_lines[$random_line];
}