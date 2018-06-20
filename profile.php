<?

include_once "includes/templates.php";
include_once "includes/profileFunctions.php";
include_once "api/class.CoolDB.php";

// GET USER DATA FROM DATABASES:
$user_id = 1;

$sql = "SELECT * FROM `users` WHERE id=?";
$db = new CoolDB();
$user_row = $db->query($sql, array($user_id));

$sql = "SELECT * FROM `profile_contacts` WHERE user_id=?";
$db = new CoolDB();
$contacts_row = $db->query($sql, array($user_id));

$sql = "SELECT * FROM `profile_links` WHERE user_id=?";
$db = new CoolDB();
$links_row = $db->query($sql, array($user_id));

//STORE DATABASE DATA TO USEFUL VARS:
$avatar = $user_row[0]["avatar"];
$first_name = $user_row[0]["first"];
$last_name = $user_row[0]["last"];
$title = $user_row[0]["title"];
$bio = $user_row[0]["bio"];
$resume = $user_row[0]["resume"];

// BUILD THE PAGE:
beginPage("home", array("styles/profile.css"));
mainMenu();

?>

        <div class="tray">
            <div class="carasol">
                    <?
                     doThingMany(5, "addThumbnail", array("imgs/placeholder-gallery-image.png"));
                    ?>
            </div>
        </div>
        <div class="content">
            <article>
                <div class="creator">
                    <div class="avatar"><img src="<?=$avatar ?>"></div>
                    <h2><?=($first_name . " " . $last_name) ?></h2>
                    <h3><?=$title ?></h3>
                </div>
                <div class="bubble top">
                    <p><? echo $bio; ?></p>
                    <div class="arrow top-left">
                        <div class="blocker"></div>
                        <div class="pointer"></div>
                    </div>
                </div>
            </article>
            <aside>
                <div class="split">
                    <div>My Resume</div>
                    <div>
                        <a href="<?=$resume ?>" class="button">Download</a>
                    </div>
                </div>
                <div class="hr"></div>
                <div class="split">
                    <div>Contact Me</div>
                    <div>
                        <ul>
                            <? foreach($contacts_row as $contact){ ?>
                                <li><a href="<?=$contact["url"]?>" class="work"><?=$contact["text"]?></a></li>
                            <? } ?>
                        </ul>
                    </div>
                </div>
                <div class="hr"></div>
                <div class="split">
                    <div>My Links</div>
                    <div>
                        <ul>
                            <? foreach($links_row as $link){ ?>
                            <li><a href="<?=$link["url"]?>" class="work"><?=$link["text"]?></a></li>
                            <? } ?>
                        </ul>
                    </div>
                </div>
            </aside>
            <section id="allProjectsSection">
                <h3 id="allProjects">All Projects</h3>
                <div class="hr"></div>
                <div class="more">
                    <? 
                    doThingMany(16, "addThumbnail", array("imgs/placeholder-gallery-image.png", "Project Name"));
                    ?>
                </div>
            </section>
            <footer></footer>
        </div>
<? endPage(); ?>        