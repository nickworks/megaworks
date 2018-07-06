<?
include_once "includes/functions.php";
include_once "includes/templates.php";
include_once "includes/class.CoolDB.php";
include_once "includes/class.User.php";

//////////////////////////////////////////////// CHECK FOR VALID PROJECT ID:

function redirect() { header("location:projects.php"); }

$id = intval(get("id"));
if($id <= 0 || empty($id)) redirect(); // invalid is, so redirect
$cURL = $_SERVER['REQUEST_URI'];
$db = new CoolDB();
$sql = "SELECT p.*, COUNT(DISTINCT pl.user_id) AS 'likes', COUNT(DISTINCT pf.user_id) AS 'faves', l.title AS 'license_title', l.copy AS 'license_copy', l.link AS 'license_link' FROM projects p, licenses l, project_likes pl, project_faves pf WHERE p.id=? AND l.id=p.license_id AND pl.project_id=p.id AND pf.project_id=p.id;";

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

$likesThis=false;
$favesThis=false;

if(User::isLoggedIn()){
    $uid=User::current()['id'];
    $temp=$db->query("SELECT COUNT(pl.id) AS 'likes_this', COUNT(pf.id) AS 'faves_this' FROM project_likes pl, project_faves pf WHERE pl.project_id=? AND pl.user_id=? AND pf.project_id=? AND pf.user_id=?;", array($id, $uid, $id, $uid));
    $likesThis=!empty($temp[0]['likes_this']);
    $favesThis=!empty($temp[0]['faves_this']);
}

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
                    <a id="bttnLike" class="button like <?if($likesThis)echo"active";?>"><span class='count'><?=$project['likes']?></span> likes<span class="icon"></span></a>
                    <a id="bttnFave" class="button fave <?if($favesThis)echo"active";?>"><?=$project['faves']?> faves<span class="icon"></span></a>
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
            <footer></footer>
        </div> <!-- end .tray -->
        <div class="content">
            <section>
                <div class="hr text"><h3><span>Comments</span></h3></div>
                <?
                foreach($comments as $comment){ 
                    comment($comment);
                }
                ?>
            </section>
            <section>
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
                <p>To add a new comment, please <a href="login.php?redirect=<?echo urlencode($cURL);?>">log in</a>!</p>
                <? } ?>
            </section>
            <footer></footer>
        </div> <!-- end .content -->
    <script>
        var projectID=<?=$id?>;
    </script>
    <script src="js/project.js"></script>
<? endPage(); ?>