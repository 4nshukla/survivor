<?php

require_once('../../core/database.class.php');

$user_id = $_POST['user_id'];
$team_picked = $_POST['team_picked'];
$current_week = $_POST['current_week'];

$db_handle = new \core\database();

$db_handle->query("INSERT INTO user_picks (user_id, week_number, team_picked) VALUES (:user_id, :week_number, :team_picked)");
$db_handle->bind(':user_id',$user_id);
$db_handle->bind(':week_number',$current_week);
$db_handle->bind(':team_picked',$team_picked);
$db_handle->execute();
