<?

include "includes/templates.php";
include "includes/profileFunctions.php";

// GET USER DATA:
$user_id = 1;
$avatar = "imgs/placeholder-avatar1.jpg";
$first_name = "Firstname";
$last_name = "Lastname";
$title = "Title";
$bio = "This is my bio.";

$resume = "#";
$contact_email = "#";
$contact_twitter = "#";
$contact_facebook = "#";

$links1_name = "My DeviantArt";
$links1_html = "#";

$links2_name = "My Grandma's Etsy";
$links2_html = "#";

$links3_name = "My Tumblr";
$links3_html = "#";

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
                            <li><a href="<?=$contact_email ?>" class="work">Email</a></li>
                            <li><a href="<?=$contact_twitter ?>" class="work">Twitter</a></li>
                            <li><a href="<?=$contact_facebook ?>" class="work">Facebook</a></li>
                        </ul>
                    </div>
                </div>
                <div class="hr"></div>
                <div class="split">
                    <div>My Links</div>
                    <div>
                        <ul>
                            <li><a href="<?=$links1_html ?>" class="work"><?=$links1_name ?></a></li>
                            <li><a href="<?=$links2_html ?>" class="work"><?=$links2_name ?></a></li>
                            <li><a href="<?=$links3_html ?>" class="work"><?=$links3_name ?></a></li>
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
            <footer>neat</footer>
        </div>
        <footer class="main"></footer>
<? endPage(); ?>        