<?
include "api/class.User.php";
include "api/functions.php";

$redirect = get("redirect");

User::logout();

if(empty($redirect)) $redirect = "index.php";
header("location:{$redirect}");

?>