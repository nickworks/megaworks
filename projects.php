<?

include_once "includes/templates.php";
include_once "includes/functions.php";
include_once "includes/class.CoolDB.php";



$db = new CoolDB();
$sql = "SELECT p.id, p.title, u.alias, i.url FROM projects p, users u, project_imgs i WHERE u.id = p.user_id AND i.project_id = p.id GROUP BY p.id ORDER BY p.id DESC;";

$projects = $db->query($sql, array(""));

//print_r($projects);die;


beginPage("projects", ["styles/projects.css"]);
mainMenu();


function assignCssClass(){
    
    $random = rand(1, 10);
    
    switch($random){
        case 1:
            return "imgHorizontal";
            break;
        case 2:
            return "imgVertical";
            break;
        case 3:
            return "imgBig";
            break;
        default:
            return "imgBox";
            break;
    }
}



?>

<div class="grid">
<?php
    
 
foreach($projects as $pro) { ?>
            <a href="<?php echo 'project.php?id='.$pro["id"]; ?>"  class="<?=assignCssClass()?>"><img src="<?php 
                echo (file_exists($pro['url'])) ? $pro['url'] : 'imgs/placeholder-gallery-image.png'; 
                ?>" />
                <span class="popup">
                    <span class="title"><? echo $pro["title"]?></span>
                    <span class="creator"><? echo $pro["alias"]?></span>
                    <span class="other">Other</span>
                </span>
            </a>
            <?php
} ?></div>
<? endPage(); ?>
