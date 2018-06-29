<?

include_once "includes/templates.php";
include_once "api/class.CoolDB.php";

// GET USER DATA FROM DATABASES:
$user_id = 1;

$sql = "SELECT * FROM `users` WHERE id=?";
$db = new CoolDB();
$user = $db->query($sql, array($user_id))[0];

$sql = "SELECT * FROM `profile_contacts` WHERE user_id=?";
$contacts = $db->query($sql, array($user_id));

$sql = "SELECT * FROM `profile_links` WHERE user_id=?";
$links = $db->query($sql, array($user_id));

$sql = "SELECT * FROM `projects` WHERE user_id=?";
$projects = $db->query($sql, array($user_id));

//STORE DATABASE DATA TO USEFUL VARS:
$avatar = User::avatar($user);
$first_name = $user["first"];
$last_name = $user["last"];
$title = $user["title"];
$bio = $user["bio"];
$resume = $user["resume"];

// BUILD THE PAGE:
beginPage("home", array("styles/profile.css"));
mainMenu();
?>

        <div class="tray">
            <div class="carasol">
                <?
                    foreach($projects as $project){
                        $image = "imgs/placeholder-gallery-image.png";
                        $title = $project['title'];
                        echo "<div class='thumbnail'>";
                        echo "<img src=\"{$image}\">";
                        if(!empty($title)) echo "<h1>{$title}</h1>"; 
                        echo "</div>";
                    }
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
                            <? foreach($contacts as $contact){ ?>
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
                            <? foreach($links as $link){ ?>
                                <li><a href="<?=$link["url"]?>" class="work"><?=$link["text"]?></a></li>
                            <? } ?>
                        </ul>
                    </div>
                </div>
            </aside>
            <section id="allProjectsSection">
                <div class="hr text"><h3><span>All Projects</span></h3></div>
                <div class="more">
                    <?
                    foreach($projects as $project){
                        $image = "imgs/placeholder-gallery-image.png";
                        $title = $project['title'];
                        echo "<div class='thumbnail'>";
                        echo "<img src=\"{$image}\">";
                        if(!empty($title)) echo "<h1>{$title}</h1>"; 
                        echo "</div>";
                    }
                    ?>
                </div>
            </section>
            <footer></footer>
        </div>
<? endPage(); ?>        