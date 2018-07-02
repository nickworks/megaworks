<?
include "includes/class.User.php";

User::logout();

header("location:index.php");

?>