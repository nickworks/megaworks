<?php

include_once "../includes/functions.php";
include_once "../includes/class.User.php";
include_once "../includes/class.MegaDB.php";

if(User::isLoggedIn()){
    
    $uid = User::current()['id'];
    $id = intval(get('id'));
    $userLikes = false;
    
    
    $likes = MegaDB::query("SELECT * FROM project_likes WHERE user_id=? AND project_id=?;", array($uid, $id));
    if(empty($likes)){ // not liked yet:
        MegaDB::query("INSERT INTO project_likes (`id`, `user_id`, `project_id`) VALUES (NULL, ?, ?);", array($uid, $id));
        $userLikes = true;
    } else { // already liked:
        MegaDB::query("DELETE FROM project_likes WHERE user_id=? AND project_id=?;", array($uid, $id));
        $userLikes = false;
    }
    $likes = MegaDB::query("SELECT COUNT(*) AS 'num' FROM project_likes WHERE project_id=?;", array($id));
    $likes = intval($likes[0]['num']);
    die("{\"project\": $id, \"likes\": $likes, \"userLikes\":".($userLikes?"true":"false")."}");
    
} else {
    die('{"error":"You must be logged in to like projects!"}');
}


?>