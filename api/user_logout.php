<?
include 'class.User.php';

User::logout();

header('location:user_demo.php');

?>