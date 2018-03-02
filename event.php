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
$sql = "SELECT * FROM `events` WHERE `id` = ?";

// grabs the information from the database
$event = $db->query($sql, array($id));
$event = $event[0];
//print_r($event); exit;
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
            <div>8 comments</div>
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
                    <li><a href="#"><time datetime="2018-01-01 20:00">Month 01, 2018</time></a></li>
                    
                    <li><time>6pm - 8pm</time></li>
                </ul>
            </div>
        </div>
        <div class="hr"><!--<h3><span>Attribution</span></h3>--></div>
        <div class="split">
            <div>Location</div>
            <div>
                <ul>
                    <li><a href="#" class="work"><?=$event['location']?></a></li>
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
                    <li><a href="#">Additional Information</a></li>
                    <li><a href="#">Additional Information</a></li>
                    <li><a href="#">Additional Information</a></li>
                    <li><a href="#">Additional Information</a></li>
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
        comment();
        comment();
        comment();
        comment();
        ?>
    </section>
    <footer></footer>
</div>
<? endPage(); ?> 