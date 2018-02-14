<?
include 'user.php';

$email = get('email');
$pass = get('pass');
$first = get('first');
$last = get('last');
$alias = get('alias');
$title = get('title');

print_r(User::new(
    $email,
    $pass,
    $first,
    $last,
    $alias,
    $title
));

?>