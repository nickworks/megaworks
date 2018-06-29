<?
include_once "api/functions.php";
include_once "includes/templates.php";
include_once "api/class.CoolDB.php";
include_once "api/class.User.php";

//////////////////////////////////////////////// CHECK FOR VALID PROJECT ID:

function redirect() { header("location:projects.php"); }

$id = intval(get("id"));
if($id <= 0 || empty($id)) redirect(); // invalid is, so redirect

$db = new CoolDB();
$sql = "SELECT projects.*, licenses.title AS 'license_title', licenses.copy AS 'license_copy', licenses.link AS 'license_link' FROM projects, licenses WHERE projects.id = ? AND licenses.id = projects.license_id;";

$rows = $db->query($sql, array($id));
if(count($rows) == 0) redirect(); // no rows were returned, so redirect

$project = $rows[0]; // <- project info

//////////////////////////////////////////////// PROCESS COMMENT FORM:

function processCommentForm($project_id){
    $comment = post("comment");
    
    if(!User::isLoggedIn()) return;
    $user_id = User::current()['id'];
    
    if(!empty($comment) && $user_id > 0){
        
        $db = new CoolDB();
        $db->query("INSERT INTO `comments_projects` (`user_id`, `project_id`, `comment`) VALUES (?, ?, ?);", array($user_id, $project_id, $comment));
        $comment_id = $db::$pdo->lastInsertId();        
        
        $values = '';
        foreach($_POST as $key => $val) {
            if(preg_match("/^commentFormTag([0-9]+)$/", $key, $matches)){
                $tag_id = intval($matches[1]);
                if(!empty($values)) $values .= ',';
                $values .= " ({$comment_id}, {$tag_id})";
            }
        }
        $sql = "INSERT INTO `comments_projects_tags` (`comment_id`, `tag_id`) VALUES {$values};";
        $db->query($sql, array());
    }
}

// putting all of this in its own function encapsulates it
// and protects variables from leaking out into global scope

processCommentForm($id);

//////////////////////////////////////////////// BEGIN PULLING DATA FROM DB:


$comments = $db->query("SELECT u.alias AS 'user_name', u.title AS 'user_title', u.avatar AS 'user_avatar', u.email AS 'user_email', c.*, GROUP_CONCAT(t.text) AS 'tags' FROM comments_projects c, comments_projects_tags j, tags_comments t, users u WHERE c.project_id=? AND t.id = j.tag_id AND j.comment_id = c.id AND u.id=c.user_id GROUP BY c.id", array($id));

$tags = $db->query("SELECT t.* FROM project_tags j, tags_projects t WHERE j.project_id=? AND j.tag_id = t.id;", array($id));

$attribution = $db->query("SELECT * FROM `project_attribution` WHERE `project_id` = ?;", array($id));

$creator = $db->query("SELECT * FROM `users` WHERE `id`=?;", array($project['user_id']))[0];

//print_r($comments); exit;

// TODO: we need to pull media
// TODO: we need to pull "likes", "faves", and "views" data

//////////////////////////////////////////////// BUILD PAGE:

// TODO: we need to make a way to "like" and/or "fave" a project

beginPage("projects");
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
                    <div class="avatar"><img src="<?=User::avatar($creator)?>"></div>
                    <h2><a href='profile.php?id=<?=$creator['id']?>' ><?=$creator['alias']?></a></h2>
                    <h3><?=$creator['title']?></h3>
                </div>
            </article>
            <aside>
                <div class="stats">
                    <?
                    $likefave;
                    ?>
                    <button class="like-button" onclick="swapThumb()">34 likes<div id="thumb" <?
                    $myLike;
                                                                                   ?> ></div></button>
                    <button class="like-button" onclick="swapHeart()">6 faves<div id="heart" <?
                    $myFave;
                                                                                  ?> ></div></button>
                    <?
                    //<div>34 likes</div>
                    //<div>6 faves</div>
                    ?>
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
                <div class="hr text"><h3><span>Comments</span></h3></div>
                
                <? foreach($comments as $comment){  ?>
                
                <div class="comment">
                    <div class="avatar"><img src="<?=User::avatar($comment['user_email'])?>"></div>
                    <div class="bubble">
                        <div class="infront">
                            <div class="tags">
                                <?
                                $tags = explode(',', $comment['tags']);
                                foreach($tags as $tag) {
                                    echo "<a class=\"button tag\">$tag</a>";
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
                    
                </div>
                
                <? } ?>
                <div class="hr text"><h3><span>New Comment</span></h3></div>
                <? if(User::isLoggedIn()) { ?>
                <form method="post" action="project.php?id=<?=$id?>">
                    <p>Choose some tags to accompany your comment:</p>
                    <div class='tag-picker'>
                    <?
                    $commentTags = $db->query("SELECT * FROM `tags_comments` ORDER BY `warn` ASC;", array());
                    foreach($commentTags as $tag){
                        $name = "commentFormTag".$tag['id'];
                        $value = $tag['text'];
                        $class = $tag['warn'] ? "issue" : "";
                        ?>
                        <input type="checkbox" value="<?=$value?>" name="<?=$name?>" id="<?=$name?>">
                        <label class="<?=$class?>" for="<?=$name?>"><?=$value?></label>
                    <? } ?>
                    </div>
                    <div class="clear"></div>
                    <p>What would you like to say?</p>
                    <textarea name="comment" style="width:100%;max-width:100%;min-width:100%;min-height:50px;height:100px;max-height:300px;"></textarea>
                    <input type="submit">
                </form>
                <? } else { ?>
                <p>To add a new comment, please <a href="login.php">log in</a>!</p>
                <? } ?>
                
            </section>
            <footer></footer>
            <script>
                function swapThumb() {
                    var element = document.getElementById("thumb");
                    
                    //INSERT INTO project_likes(user_id, project_id) VALUES(1, 5)
                    
                    if(element.classList.contains("like-activate"))element.classList.remove("like-activate");
                    else element.classList.add("like-activate");
                }
                function swapHeart() {
                    var element = document.getElementById("heart");
                    
                    if(element.classList.contains("like-activate"))element.classList.remove("like-activate");
                    else element.classList.add("like-activate");
                }
            </script>
        </div>
<? endPage(); ?>