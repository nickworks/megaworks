<?php

include_once "../includes/functions.php";
include_once "../includes/class.User.php";
include_once "../includes/class.CoolDB.php";

if(User::isLoggedIn()){
    
    $uid = User::current()['id'];
    $id = intval(get('id'));
    $userFaves = false;
    
    $db = new CoolDB();
    $faves = $db->query("SELECT * FROM project_faves WHERE user_id=? AND project_id=?;", array($uid, $id));
    if(empty($faves)){ // not faved yet:
        $db->query("INSERT INTO project_faves (`id`, `user_id`, `project_id`) VALUES (NULL, ?, ?);", array($uid, $id));
        $userFaves = true;
    } else { // already faved:
        $db->query("DELETE FROM project_faves WHERE user_id=? AND project_id=?;", array($uid, $id));
        $userFaves = false;
    }
    $faves = $db->query("SELECT COUNT(*) AS 'num' FROM project_faves WHERE project_id=?;", array($id));
    $faves = intval($faves[0]['num']);
    die("{\"project\": $id, \"faves\": $faves, \"userFaves\":".($userFaves?"true":"false")."}");
    
} else {
    die('{"error":"You must be logged in to fave a project!"}');
}


?>