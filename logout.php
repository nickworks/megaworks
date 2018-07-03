<?
include_once "includes/class.User.php";
include_once "includes/functions.php";

$redirect = get("redirect");

User::logout();

if(empty($redirect)) $redirect = "index.php";
header("location:{$redirect}");

?>