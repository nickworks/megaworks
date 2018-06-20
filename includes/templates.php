<?

include_once "api/class.User.php";

function beginPage(string $class, $css = null){
    
    if(is_string($css)) $css = array($css);
    
?><!doctype html>
    
<html lang="en-US">
    
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
    <footer class="footer">        
        <div class="box">
            
        <div class="top">
            
            <div> <li class="top_list"><a href="about.php">About</a></li></div>
            <div class="top_list"> <a href="projects.php">Projects</a></div>            
            <div class="top_list"> <a href="events.php">Events</a> </div>
            <div class="top_list"> <a href="talk.php">Discord</a> </div>
            <div class="top_list"> <a href="about.php">Youtube</a></div>
            <div class="top_list"> <a href="about.php">Facebook</a></div>
            
        </div>
            <div class="hr"><h3></h3></div>

        <div class="copyright">
            <div class="copy_list"> Use of this site constitutes acceptance of our <a href="about.php">User Agreement</a> and <a href="about.php">Private Policy</a>. all rights reserved </div>
        
              
        </div> 
        
        
        
        </div>       
        </footer>
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

function event(string $id, string $time, string $title, string $location, string $location_link, string $description, string $eventImage){?>
<li>
    <figure>
        <a href="<? echo "event.php?id=".$id; ?>" id="eventPicture" style="background-image: url('<? echo $eventImage?>');"></a>
    </figure>
    <div>
        <h2><a href="<? echo "event.php?id=".$id; ?>"><? echo $title; ?></a></h2>
        <time><? echo "Time: ".$time; ?></time>
        <h3><a href="<? echo $location_link;?>"><? echo "Location: ".$location; ?></a></h3>
    <!--
    title
    time
    location
    description
    -->
        <p><? echo $description; ?></p>
    </div>
</li>
<?}

function comment(string $comment){?>
<div class="comment">
    <div class="avatar">
        <img src="imgs/placeholder-avatar1.jpg">
    </div>
    <div class="bubble">
        <p><?=$comment?></p>
        <div class="arrow left-top">
            <div class="blocker"></div>
            <div class="pointer"></div>
        </div>
    </div>
</div>
<?}


?>