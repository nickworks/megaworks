<?

include_once "includes/templates.php";
include_once "includes/class.MegaDB.php";
include_once "includes/class.User.php";


// GET USER DATA FROM DATABASES:

$user_id = get('id');
    
$sql = "SELECT * FROM `users` WHERE id=?";

$user = MegaDB::query($sql, array($user_id));
if(empty ($user) )header('location: 404.php');
$user = $user[0];

$sql = "SELECT * FROM `profile_contacts` WHERE user_id=?";
$contacts = MegaDB::query($sql, array($user_id));

$sql = "SELECT * FROM `profile_links` WHERE user_id=?";
$links = MegaDB::query($sql, array($user_id));

$sql = "SELECT * FROM `projects` WHERE user_id=?";
$projects = MegaDB::query($sql, array($user_id));

//STORE DATABASE DATA TO USEFUL VARS:
$avatar = User::avatar($user);
$first_name = $user["first"];
$last_name = $user["last"];
$title = $user["title"];
$bio = $user["bio"];
$resume = $user["resume"];

/**
 * This function creates a bunch of thumbnails.
 * $projects    An array of projects.
 */
function thumbnails($projects){
    foreach($projects as $project){
        $image = "imgs/placeholder-gallery-image.png";
        $title = $project['title'];
        $id = $project['id'];
        echo "<a class='thumbnail' href='project.php?id={$id}'>";
        echo "<img src=\"{$image}\">";
        if(!empty($title)) echo "<span class='title'>{$title}</span>"; 
        echo "</a>";
    }
}

// BUILD THE PAGE:
beginPage("home", array("styles/profile.css"));
mainMenu();
?>
        <div class="tray">
            <article>
                <div class="creator">
                    <div class="avatar"><img src="<?=$avatar ?>"></div>
                    <h2><?=$first_name?> <?=$last_name?> <em><?=$user['alias']?></em></h2>
                    <h3><?=$title ?></h3>
                    <div class="clear"></div>
                </div>
                <div class="bubble">
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
            <footer></footer>
        </div>
        <div class="content">
            <h1>My Portfolio</h1>
            <section>
                <div class="hr text"><h3><span>My Faves</span></h3></div>
                <? thumbnails($projects); ?>
                <div class="clear"></div>
            </section>
            <section>
                <div class="hr text"><h3><span>All Projects</span></h3></div>
                <? thumbnails($projects); ?>
                <div class="clear"></div>
            </section>
            <footer></footer>
        </div>
<? endPage(); ?>        