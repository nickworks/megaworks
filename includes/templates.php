<?

include_once "api/class.User.php";

function beginPage(string $class, $css = null){
    
    if(is_string($css)) $css = array($css);
    
?><!doctype html>
<html>
    <head>
        <link href="styles/main.css" rel="stylesheet">
<?
if(is_array($css)){
    foreach($css as $file){
        echo "<link href='{$file}' rel='stylesheet'>";
    }
}
?>
    </head>
    <body class="<? echo $class; ?>">  
<?}

function endPage(){?>
    <footer class="main"></footer>
    </body>
</html>
<?}


function mainMenu(){

$showProfile = User::isLoggedIn();

?>
<nav class="main">
    <a href="index.php"><div id="logo"></div></a>
    <ul>
        <li><a href="about.php">about</a></li>
        <li><a href="projects.php">projects</a></li>
        <li><a href="talk.php">talk</a></li>
        <li><a href="events.php">events</a></li>
        <? if($showProfile) { ?>
        <li><a href="profile.php">profile</a></li>
        <? } else { ?>
        <li><a href="login.php">login</a></li>
        <? } ?>
    </ul>
</nav>
<?}

function event(string $time, string $title, string $description){?>
<li>
    <figure>
        <a href="event.php" id="eventPicture"></a>
    </figure>
    
    <h2><a href="event.php"><? echo $title; ?></a></h2>
    <time><? echo "Time: ".$time; ?></time>
    <!--
    title
    time
    location
    description
    -->
    <p><? echo $description; ?></p>
</li>
<?}

function comment(){?>
<div class="comment">
    <div class="avatar">
        <img src="imgs/placeholder-avatar1.jpg">
    </div>
    <div class="bubble">
        <p>Lorem ipsum. lots of text goes here. This is the comment that the other user has typed in. Neat.</p>
        <div class="arrow left-top">
            <div class="blocker"></div>
            <div class="pointer"></div>
        </div>
    </div>
    <div class="tags">
        <a href="#" class="button tag">awesome!</a>
        <a href="#" class="button tag issue">possible license issues</a>
    </div>
</div>
<?}


?>