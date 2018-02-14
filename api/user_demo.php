<?
include 'user.php';

print_r(User::current());

echo User::isAdmin() ? "admin" : "not admin";
echo "\n\n";
echo User::isMod() ? "mod" : "not mod";


?>