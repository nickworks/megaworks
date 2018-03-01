<?

include_once "includes/templates.php";
include_once "api/functions.php";
include_once "api/class.CoolDB.php";



$db = new CoolDB();
$sql = "SELECT projects.title, projects.id, users.alias FROM projects, users WHERE users.id = projects.user_id ORDER BY projects.id DESC;";
$img = "SELECT project_imgs.url, project_imgs.project_id FROM `project_imgs` ORDER BY project_imgs.ordering ASC, project_imgs.project_id ASC;";

$imageURL = $db->query($img, array(""));
$projects = $db->query($sql, array(""));

//print_r($projects[0]["id"]);die;


beginPage("projects", ["styles/projects.css"]);
mainMenu();


?>

<?

function arrayRandom($arr, $num = 1) {
    shuffle($arr);
    
    $r = array();
    for($i = 0; $i < $num; $i++) {
        $r[] = $arr[$i];
    }
    
    return $num == 1 ? $r[0] : $r;
}

function assignCssClass(){
    $cssArray = array( "imgHorizontal","imgVertical","imgBig","imgBox");
    
    $class = arrayRandom($cssArray);
    
    return $class;
}



?>

<div class="grid">
<?php
//$folder_path = 'imgs/gallery/'; //image's folder path

$num_files = $projects[0]["id"];

//$folder = opendir($folder_path);
 
while($num_files > 0)
{
   ?>
            <a href="<?php echo 'project.php?id='.$num_files; ?>"  class="<?=assignCssClass()?>"><img src="<?php echo $imageURL[$num_files - 1]['url']; ?>" />
                <span class="popup">
                    <h1><? echo $projects[count($projects) - $num_files]["title"]?></h1>
                    <h2><? echo $projects[count($projects) - $num_files]["alias"]?></h2>
                    <h3>Other</h3>
                </span>
            </a>
            <?php
    $num_files--;
}
//closedir($folder);
    ?></div>
<? endPage(); ?>        