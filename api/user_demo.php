<?
include 'class.User.php';


function profileData(){
    
    $user = User::current();
    
    if(empty($user)){
        echo "<p>You are NOT logged in. <a href='user_login.php'>Login</a></p>";
        return;
    }
    
    echo "<p>Hello, {$user['alias']}! <a href='user_logout.php'>Logout</a></p>";
    
    echo "<p>You are";
    if(!User::isApproved()) echo " NOT";
    echo " an approved user.</p>";
    
    echo "<p>You are";
    if(!User::isAdmin()) echo " NOT";
    echo " an admin.</p>";

    echo "<p>You are";
    if(!User::isAdmin()) echo " NOT";
    echo " a mod.</p>";
}

profileData();

?>