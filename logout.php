<?
include "api/class.User.php";

User::logout();

header("location:index.php");

?>