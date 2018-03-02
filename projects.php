<?

include_once "includes/templates.php";
include_once "api/functions.php";
include_once "api/class.CoolDB.php";



$db = new CoolDB();
$sql = "SELECT p.id, p.title, u.alias, i.url FROM projects p, users u, project_imgs i WHERE u.id = p.user_id AND i.project_id = p.id GROUP BY p.id ORDER BY p.id DESC;";

$projects = $db->query($sql, array(""));

//print_r($projects);die;


beginPage("projects", ["styles/projects.css"]);
mainMenu();


?>

<?
function assignCssClass(){
    $cssArray = array( "imgHorizontal","imgVertical","imgBig","imgBox");
    
    shuffle($cssArray);
    
    $class = $cssArray[0];
    
    return $class;
}



?>

<div class="grid">
<?php
//$folder_path = 'imgs/gallery/'; //image's folder path

//$num_files = $projects[0]["id"];

//$folder = opendir($folder_path);
 
foreach($projects as $pro)
{
   ?>
            <a href="<?php echo 'project.php?id='.$pro["id"]; ?>"  class="<?=assignCssClass()?>"><img src="<?php echo $pro['url']; ?>" />
                <li class="popup">
                    <ul><span class="title"><? echo $pro["title"]?></span></ul>
                    <ul><span class="creator"><? echo $pro["alias"]?></span></ul>
                    <ul><span class="other">Other</span></ul>
                </li>
            </a>
            <?php
}
//closedir($folder);
    ?></div>
<? endPage(); ?>        