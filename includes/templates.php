<?

include_once "class.User.php";

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
    $cURL = $_SERVER['REQUEST_URI'];
    $uid = User::current()['id'];
    
    ?><footer class="footer">
        <nav>
            <ul>
                <li><a class="about" href="about.php">About</a></li>
                <li><a class="projects" href="projects.php">Projects</a></li>
                <li><a class="talk" href="talk.php">Community</a></li>
                <li><a class="events" href="events.php">Events</a> </li>
                <li>|</li>
                <li><a class="bylaws" href="https://docs.google.com/document/d/1GaI0X1x5A0B0OwSkmx-xA56ebZ8_UZMd-PDjs18u9YQ/edit?usp=sharing">Bylaws</a></li>
                <li><a id="feedback" href="https://github.com/nickworks/megaworks/issues">Leave Feedback</a> </li>
                <li>|</li>
                <? if($showProfile) { ?>
                    <li><a class="profile" href="profile.php?id=<? echo $uid; ?>">My Account</a></li>
                    <li><a href="logout.php?redirect=<?echo urlencode($cURL);?>">Sign Out</a></li>
                <? } else { ?>
                    <li><a class="login" href="login.php?redirect=<?echo urlencode($cURL);?>">Login</a></li>
                    <li><a class="signup" href="signup.php">Sign Up</a></li>
                <? } ?>
                
                
                <li class="spacer"></li>                
                <li><a class="discord" href="https://discord.gg/jySFz6V" target="_blank"><span class="hide">Discord</span></a> </li>
                <li><a class="youtube" href="https://youtu.be/cSGKClvHmrI" target="_blank"><span class="hide">Youtube</span></a></li>
                <li><a class="facebook" href="https://www.facebook.com/groups/31875193841/" target="_blank"><span class="hide">Facebook</span></a></li>
                <li><a class="steam" href="https://steamcommunity.com/groups/fsu-dagd" target="_blank"><span class="hide">Steam</span></a></li>
            </ul>
        </nav>
        <div class="hr"><h3></h3></div>
        <div class="copyright">
            <p>Use of this site constitutes acceptance of our <a href="about.php">User Agreement</a> and <a href="about.php">Private Policy</a>. all rights reserved.</p>
        </div>
        </footer>
    </body>
</html>
<?}

function mainMenu(){

$showProfile = User::isLoggedIn();
$cURL = $_SERVER['REQUEST_URI'];
$uid = User::current()['id'];
?>
<nav class="main">
    <a href="index.php"><div id="logo"></div></a>
    <ul>
        <li><a class="about" href="about.php">About</a></li>
        <li><a class="projects" href="projects.php">Projects</a></li>
        <li><a class="talk" href="talk.php">Community</a></li>
        <li><a class="events" href="events.php">Events</a></li>
        <li class="spacer"></li>
        <? if($showProfile) { ?>
            <li><a class="profile" href="profile.php?id=<? echo $uid ?>">My Account</a></li>
            <li><a href="logout.php?redirect=<?echo urlencode($cURL);?>">Log Off</a></li>
        <? } else { ?>
            <li><a class="login" href="login.php?redirect=<?echo urlencode($cURL);?>">Login</a></li>
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

function comment(array $comment){

$avatar = array_key($comment, 'user_email');
$avatar = User::avatar($avatar);
?>
<div class="comment">
    <div class="avatar"><img src="<?=$avatar?>"></div>
    <div class="bubble">
        <div class="infront">
            <div class="tags">
                <?
                if(array_key_exists('tags', $comment)){
                    $tags = explode(',', $comment['tags']);
                    foreach($tags as $tag) {
                        echo "<a class=\"button tag\">$tag</a>";
                    }
                }
                ?>
            </div>
            <h1>
                <a href="profile.php?id=<?=$comment['user_id']?>"><?=$comment["user_name"]?></a>
                <span><?=$comment["user_title"]?></span>
            </h1>
            <p><?=$comment["comment"]?></p>
            <time><?=easyDate($comment["date_posted"])?></time>
            <div class="clear"></div>
        </div>
        <div class="arrow left-top">
            <div class="blocker"></div>
            <div class="pointer"></div>
        </div>
    </div>
    </div><!-- end comment -->
<? }

function errors($errs){
    if (is_array($errs) && !empty($errs)){
        echo "<ul class='errorMessage'>";
        foreach($errs as $err){
            echo "<li>$err</li>";
        }
        echo "</ul>";
    }
}
?>