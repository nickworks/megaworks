<?
include_once "includes/functions.php";
include_once "includes/templates.php";
include_once "includes/class.CoolDB.php";
include_once "includes/class.User.php";

// gets the event id its trying to access
$id = intval(get("id"));
// checks to see if the id exists/ if not redirects back to the events page
if($id <= 0) header("location:events.php");
$cURL = htmlentities($_SERVER['REQUEST_URI']);
// grabs the information from the database
$db = new CoolDB();
$event = $db->query("SELECT * FROM `events` WHERE `id`=?", array($id))[0];
$comments = $db->query("SELECT u.alias AS 'user_name', u.title AS 'user_title', u.avatar AS 'user_avatar', u.email AS 'user_email', c.* FROM comments_events c, users u WHERE c.event_id=? AND u.id=c.user_id", array($id));
$event_links = $db->query("SELECT * FROM `event_links` WHERE `event_id` = ?", array($id));
$event_downloads = $db->query("SELECT * FROM `event_downloads` WHERE `event_id` = ?", array($id));

//print_r($comments); exit;

// START DATETIME:
$sd = new DateTime($event["date_start"]);
$fsd = date_format($sd, 'M d, Y h:i');
$psd = date_parse($fsd);

// END DATETIME:
$ed = new DateTime($event["date_end"]);
$fed = date_format($ed, 'M d, Y h:i');
$ped = date_parse($fed);

// checks the start date to the end date and formats the dates accordingly
if($psd['year'] == $ped['year'] && $psd['month'] == $ped['month']&& $psd['day'] == $ped['day']) {
    $mdy = date_format($sd, 'M d, Y');
    $time = date_format($sd, 'gA')." - ".date_format($ed, 'gA');
} else if($psd['year'] == $ped['year'] && $psd['month'] == $ped['month']&& $psd['day'] != $ped['day']) {
    $mdy = date_format($sd, 'M d').' - '.date_format($ed, 'd').', '.date_format($sd, 'Y');
    $time = date_format($sd, 'gA')." - ".date_format($ed, 'gA');
} else if($psd['year'] == $ped['year'] && $psd['month'] != $ped['month']) {
    $mdy = date_format($sd, 'M d').' - '.date_format($ed, 'M d').', '.date_format($sd, 'Y');
    $time = date_format($sd, 'gA')." - ".date_format($ed, 'gA');
} else if($psd['year'] != $ped['year']) {
    $mdy = date_format($sd, 'M d, Y').' - '.date_format($ed, 'M d, Y');
    $time = date_format($sd, 'gA')." - ".date_format($ed, 'gA');
}

beginPage("events");
mainMenu();
?>
<div class="tray">
    <article>
        <h1><?=$event["title"]?></h1>
        <div class="bubble"><div class="inner"><?=$event["description"]?></div></div>
    </article>
    <aside>
        <div class="stats">
            <div>34 likes</div>
            <div>6 faves</div>
            <div>240 views</div>
            <div><?=count($comments)?> comments</div>
        </div>
        <div class="hr"></div>
        <div class="split">
            <div>Date</div>
            <div><time><?=$mdy?><br><?=$time?></time></div>
        </div>
        <div class="split">
            <div>Location</div>
            <div>
                <?
                if (empty($event['location_link'])) {
                    echo $event['location'];
                } else {
                    echo '<a href="'.$event['location_link'].'" class="work">';
                    echo $event['location'];
                    echo '</a>';
                }
                echo "<address>".$event['address'].",<br>";
                echo $event['city_state_zip']."</address>";
                ?>
            </div>
        </div>
        <div class="split">
            <div>Links</div>
            <div>
                <ul>
                    <? foreach ($event_links as $link) { ?>
                            <li><a href="<?=$link["url"]?>" class="work"><?=$link["text"]?></a></li>
                      <?  } ?>
                </ul>
            </div>
        </div>
        <div class="split">
            <div>Downloads</div>
            <div>
                 <? foreach ($event_downloads as $download) { ?>
                    <li><a href="<?=$download["url"]?>" class="work"><?=$download["text"]?></a></li>
                <?  } ?>
            </div>
        </div>
    </aside>
    <footer></footer>
</div>
<div class="content">
    <div class="hr text"><h3><span>Comments</span></h3></div>
    <? 
    foreach ($comments as $comment) {
        comment($comment);
    }
    ?>
    
    <div class="hr text"><h3><span>New Comment</span></h3></div>
    <?   //TODO: FORM IS NON FUNCTIONAL
    if(User::isLoggedIn()) { 
    ?>
    
    <form method="post" action="event.php?id=<?=$id?>">
        
        <div class="clear"></div>    

        <p>What would you like to say?</p>
        
        <textarea name="comment" style="width:100%;max-width:100%;min-width:100%;min-height:50px;height:100px;max-height:300px;"></textarea>
        
        <button type="submit" id="submit-bttn">Submit</button>
        
        
    </form>
    <? } else { ?>
        <p>To add a new comment, please <a href="login.php?redirect=<?echo urlencode($cURL);?>">log in</a>!</p>
    <? } ?>
    
  <footer></footer>
</div>
<? endPage(); ?> 