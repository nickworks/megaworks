<?
include_once "api/functions.php";
include_once "includes/templates.php";
include_once "api/class.CoolDB.php";

// redirects to events page
function redirectToEvents() { header("location:events.php"); }

$db = new CoolDB();

// gets the event id its trying to access
$id = intval(get("id"));
// checks to see if the id exists/ if not redirects back to the events page
if($id <= 0 || empty($id)) redirectToEvents();

// creates a sql query to access the information for the desired page
$event_sql = "SELECT * FROM `events` WHERE `id` = ?";
$comment_sql = "SELECT * FROM `comments_events` WHERE `event_id` = ? ORDER BY `comments_events`.`date_posted` DESC";
$event_links_sql = "SELECT * FROM `event_links` WHERE `event_id` = ?";

// grabs the information from the database
$event = $db->query($event_sql, array($id));
$comments = $db->query($comment_sql, array($id));
$event = $event[0];
$event_links = $db->query($event_links_sql, array($id));

// formatting the date
$sd = new DateTime($event["date_start"]);
$fsd = date_format($sd, 'M d, Y h:i');
$psd = date_parse($fsd);
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

//print_r($comments); exit;
beginPage("event", "styles/event.css");
mainMenu();
?>
<div class="tray">
    <div class="feature">
    </div>
</div>
<div class="content">
    <aside>
        <div class="stats">
            <div>34 likes</div>
            <div>6 faves</div>
            <div>240 views</div>
            <div><?=count($comments)?> comments</div>
        </div>
        <div class="hr"><!--<h3><span>Downloads</span></h3>--></div>
        <div class="split">
            <div>Downloads</div>
            <div>
                <a href="#" class="button">Additional Information</a>
            </div>
        </div>
        <div class="hr"><!--<h3><span>License</span></h3>--></div>
        <div class="split">
            <div>Date</div>
            <div>
                <ul>
                    <li><time><?=$mdy?></time></li>
                    <li><time><?=$time?></time></li>
                </ul>
            </div>
        </div>
        <div class="hr"><!--<h3><span>Attribution</span></h3>--></div>
        <div class="split">
            <div>Location</div>
            <div>
                <ul>
                    <?
                    if (empty($event['location_link'])) {
                        ?><li class="work"><?=$event['location']?></li><?
                    } else {
                         ?><li><a href="<?=$event['location_link']?>" class="work"><?=$event['location']?></a></li><?
                    }
                    ?>
                    <li><address><?=$event['address'].","?></address></li>
                    <li><address><?=$event['city_state_zip']?></address></li>
                </ul>
            </div>
        </div>
        <div class="hr"><!--<h3><span>Tags</span></h3>--></div>
        <div class="split">
            <div>Links</div>
            <div>
                <ul>
                    <? 
                        foreach ($event_links as $link) {
                            
                        }
                    ?>
                </ul>
            </div>
        </div>
    </aside>
    <section>
        <div class="description">
            <h1><?=$event["title"]?></h1>
            <article>
                <?=$event["description"]?>
            </article>
        </div>
    </section>
    <section>
        <div class="rsvp">
            <h1>RSVP</h1>
            <form>
                <div>
                    <h1>Your Name</h1>
                    <input type="text">
                </div>
                <div>
                    <h1>Additional People</h1>
                    <input type="text">
                </div>
                <div>
                    <h1>Special Notes (allergies, accomidations, etc)</h1>
                    <input type="text">
                </div>
                <div>
                    <button>Submit RSVP</button>
                </div>
            </form>
        </div>
    </section>
    <section>
        <div class="hr"><h3><span>Comments</span></h3></div>
        <? 
        foreach ($comments as $comment) {
            comment($comment['comment']);
        }
        ?>
    </section>
  <footer></footer>
</div>
<? endPage(); ?> 