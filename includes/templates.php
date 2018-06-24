<?

include_once "api/class.User.php";

function easyDate($mysql){
    return date('M d @ h:i a', strtotime($mysql));
}

function beginPage(string $class = "", $css = null){
    
    if(is_string($css)) $css = array($css);
    
    ?><!doctype html><html lang="en-US">
    <head><link href="styles/main.css" rel="stylesheet">
    <? if(is_array($css)){
        foreach($css as $file){
            echo "<link href='{$file}' rel='stylesheet'>";
        }
    } ?>
    </head><body class="<? echo $class; ?>">
    <div id="bug-issues"><a href="https://github.com/nickworks/megaworks/issues" target="_blank">give us feedback</a></div>
<?}

function endPage(){
    $showProfile = User::isLoggedIn();
    ?><footer class="footer">
        <nav>
            <ul>
                <li><a class="about" href="about.php">About</a></li>
                <li><a class="projects" href="projects.php">Projects</a></li>
                <li><a class="talk" href="talk.php">Talk</a></li>
                <li><a class="events" href="events.php">Events</a> </li>
                <li>|</li>
                <? if($showProfile) { ?>
                    <li><a class="profile" href="profile.php">My Account</a></li>
                    <li><a href="logout.php">Sign Out</a></li>
                <? } else { ?>
                    <li><a class="login" href="login.php">Login</a></li>
                    <li><a class="signup" href="signup.php">Sign Up</a></li>
                <? } ?>
                <li>|</li>
                <li><a id="feedback" href="https://github.com/nickworks/megaworks/issues">Leave Feedback</a> </li>
                <li class="spacer"></li>                
                <li><a class="discord" href="#"><span class="hide">Discord</span></a> </li>
                <li><a class="youtube" href="#"><span class="hide">Youtube</span></a></li>
                <li><a class="facebook" href="#"><span class="hide">Facebook</span></a></li>
                <li><a class="steam" href="#"><span class="hide">Steam</span></a></li>
            </ul>
        </nav>
        <div class="hr"><h3></h3></div>
        <div class="copyright">
            <p>Use of this site constitutes acceptance of our <a href="about.php">User Agreement</a> and <a href="about.php">Private Policy</a>. all rights reserved </p>
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
        <li><a class="about" href="about.php">About</a></li>
        <li><a class="projects" href="projects.php">Projects</a></li>
        <li><a class="talk" href="talk.php">Talk</a></li>
        <li><a class="events" href="events.php">Events</a></li>
        <li class="spacer"></li>
        <? if($showProfile) { ?>
            <li><a class="profile" href="profile.php">My Account</a></li>
            <li><a href="logout.php">Log Off</a></li>
        <? } else { ?>
            <li><a class="login" href="login.php">Login</a></li>
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