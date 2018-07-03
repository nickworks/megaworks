<?
include "includes/class.User.php";

$redirect = get("redirect");

User::logout();

if(empty($redirect)) $redirect = "index.php";
header("location:{$redirect}");

?>