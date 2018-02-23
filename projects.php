<?

include_once "includes/templates.php";
include_once "api/functions.php";
include_once "api/class.CoolDB.php";

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
$folder_path = 'imgs/gallery/'; //image's folder path

$num_files = glob($folder_path . "*.{JPG,jpg,gif,png,bmp}", GLOB_BRACE);

$folder = opendir($folder_path);
 
if($num_files > 0)
{
 while(false !== ($file = readdir($folder))) 
 {
     
  $file_path = $folder_path.$file;
  $extension = strtolower(pathinfo($file ,PATHINFO_EXTENSION));
  if($extension=='jpg' || $extension =='png' || $extension == 'gif' || $extension == 'bmp') 
  {
   ?>
            <a href="<?php echo $file_path; ?>"  class="<?=assignCssClass()?>"><img src="<?php echo $file_path; ?>" />
                <span class="popup">
                    <h1>Title</h1>
                    <h2>Name</h2>
                    <h3>Other</h3>
                </span>
            </a>
            <?php
  }
 }
}
else
{
 echo "the folder was empty !";
}
closedir($folder);
    ?></div>
<? endPage(); ?>        