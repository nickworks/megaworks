<?

function beginPage(string $class, $css = null){
    
    if(is_string($css)) $css = array($css);
    
?><!doctype html>
<html>
    <head>
        <link href="styles/main.css" rel="stylesheet">
<?
if(is_array($css)){
    foreach($css as $file){
        echo "<link href='{$file}' rel='stylesheet'>";
    }
}
?>
    </head>
    <body class="<? echo $class; ?>">  
<?}

function endPage(){?>
    <footer class="main"></footer>
    </body>
</html>
<?}


function mainMenu(){?>
<nav class="main">
    <a href="index.html"><div id="logo"></div></a>
    <ul>
        <li><a href="about.html">about</a></li>
        <li><a href="projects.html">projects</a></li>
        <li><a href="talk.html">talk</a></li>
        <li><a href="events.html">events</a></li>
        <li><a href="login.html">login</a></li>
    </ul>
</nav>
<?}



?>