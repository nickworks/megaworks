<?
include_once "api/functions.php";
include_once "includes/templates.php";
include_once "api/class.CoolDB.php";

// TODO: process comment form and insert comment into database

$id = intval(get("id"));

if($id <= 0 || empty($id)) header("location:projects.php");

$db = new CoolDB();
$sql = "SELECT projects.*, licenses.title AS 'license_title', licenses.copy AS 'license_copy', licenses.link AS 'license_link' FROM projects, licenses WHERE projects.id = ? AND licenses.id = projects.license_id;";

$rows = $db->query($sql, array($id));

if(count($rows) == 0) header("location:projects.php"); // no rows were returned, so redirect

$project = $rows[0];

$comments = $db->query("SELECT * FROM `comments_projects` WHERE `project_id`=?;", array($id));

$tags = $db->query("SELECT tags_projects.* FROM project_tags, tags_projects WHERE project_tags.project_id=? AND project_tags.tag_id = tags_projects.id;", array($id));

$attribution = $db->query("SELECT * FROM `project_attribution` WHERE `project_id` = ?;", array($id));

//print_r($attribution); exit;

// TODO: we need to pull the student data
// TODO: we need to pull comment tags
// TODO: we need to pull media

beginPage("project");
mainMenu();
?>
        <div class="tray">
            <div class="feature">
                <img src="imgs/placeholder-gallery-image.png">
            </div>
        </div>
        <div class="content">
            <article>
                <h1><?=$project["title"]?></h1>
                <div class="bubble bottom">
                    <p><?=$project["description"]?></p>
                    <div class="arrow bottom-left">
                        <div class="blocker"></div>
                        <div class="pointer"></div>
                    </div>
                </div>
                <div class="creator">
                    <div class="avatar"><img src="imgs/placeholder-avatar1.jpg"></div>
                    <h2>Namey McStudent</h2>
                    <h3>Texture Artist</h3>
                </div>
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
                    <div>Downloads</div>
                    <div>
                        <a href="#" class="button">The Game</a>
                        <a href="#" class="button">Source Code</a>
                    </div>
                </div>
                
                
                <? if(!empty($project["license_id"])) { ?>
                <div class="hr"></div>
                <div class="split">
                    <div>License</div>
                    <div><a href="<?=$project["license_link"]?>" target="_blank" class="button license"><?=$project["license_title"]?>
                        <span class="bubble">
                            <span class="arrow top-right">
                                <span class="blocker"></span>
                                <span class="pointer"></span>
                            </span>
                            <span class="p"><em>Permissions:</em> You can do anything you want with this work.</span>
                            <span class="p"><em>Conditions:</em> You must provide attribution back to me.</span>
                            <span class="p"><em>Limitations:</em> I am waived of all liability, and the license provides no warranty.</span>
                        </span>
                    </a></div>
                </div> 
                <? } ?>
                
                <? if(count($attribution) > 0){ ?>
                <div class="hr"></div>
                <div class="split">
                    <div>Attribution</div>
                    <div>
                        <ul>
                            <? foreach($attribution as $attr){ ?>
                            <li><a href="<?=$attr['work_link']?>" class="work"><?=$attr['work']?></a> by <?=$attr['creator']?> <span class="license">(<?=$attr['license_id']?>)</span></li>
                            <? } ?>
                        </ul>
                    </div>
                </div>
                <? } ?>
                
                <div class="hr"></div>
                <div class="split">
                    <div>Tags</div>
                    <div>
                        <? foreach($tags as $tag){ ?>
                        <a href="projects.php?tag=<?=$tag['id']?>" class="tag button"><?=$tag["text"]?></a>
                        <? } ?>
                    </div>
                </div>
            </aside>
            <section>
                <div class="hr"><h3><span>Comments</span></h3></div>
                
                <? foreach($comments as $comment){  ?>
                
                <div class="comment">
                    <div class="avatar">
                        <img src="imgs/placeholder-avatar1.jpg">
                    </div>
                    <div class="bubble">
                        <p><?=$comment["comment"]?></p>
                        <div class="arrow left-top">
                            <div class="blocker"></div>
                            <div class="pointer"></div>
                        </div>
                    </div>
                    <div class="tags">
                        <a href="#" class="button tag">awesome!</a>
                        <a href="#" class="button tag issue">possible license issues</a>
                    </div>
                </div>
                
                <? } ?>
                
                
            </section>
            <footer>neat</footer>
        </div>
<? endPage(); ?>