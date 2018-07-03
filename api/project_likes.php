<?php

include_once "../includes/functions.php";
include_once "../includes/class.User.php";
include_once "../includes/class.CoolDB.php";

if(User::isLoggedIn()){
    
    $uid = User::current()['id'];
    $id = intval(get('id'));
    $userLikes = false;
    
    $db = new CoolDB();
    $likes = $db->query("SELECT * FROM project_likes WHERE user_id=? AND project_id=?;", array($uid, $id));
    if(empty($likes)){ // not liked yet:
        $db->query("INSERT INTO project_likes (`id`, `user_id`, `project_id`) VALUES (NULL, ?, ?);", array($uid, $id));
        $userLikes = true;
    } else { // already liked:
        $db->query("DELETE FROM project_likes WHERE user_id=? AND project_id=?;", array($uid, $id));
        $userLikes = false;
    }
    $likes = $db->query("SELECT COUNT(*) AS 'num' FROM project_likes WHERE project_id=?;", array($id));
    $likes = intval($likes[0]['num']);
    die("{project: $id, likes: $likes, userLikes:".($userLikes?"true":"false")."}");
    
} else {
    die("{error:'You must be logged in to like projects!'}");
}


?>