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
        <li><a href="about.php">about</a></li>
        <li><a href="projects.php">projects</a></li>
        <li><a href="talk.php">talk</a></li>
        <li><a href="events.php">events</a></li>
        <li><a href="login.php">login</a></li>
    </ul>
</nav>
<?}

function event(string $time, string $title){?>
<li>
    <figure>
        <a href="event.php" id="eventPicture"></a>
        <time><? echo $time; ?></time>
    </figure>
    
    <h2><a href="event.php"><? echo $title; ?></a></h2>
    <p>Description of Event - Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis quasi architecto vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quiamagni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam voluptatem. Ut enim ad minima veniam, quis nostrum exercitationemcorporis suscipit laboriosam, nisi ut exercitation ullamco laboris nisi ut aliquip ex ea commodo aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis quasi architecto vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quiamagni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam voluptatem. Ut enim ad minima veniam, quis nostrum exercitationemcorporis suscipit laboriosam, nisi ut</p>
</li>
<?}

function comment(){?>
<div class="comment">
    <div class="avatar">
        <img src="imgs/placeholder-avatar1.jpg">
    </div>
    <div class="bubble">
        <p>Lorem ipsum. lots of text goes here. This is the comment that the other user has typed in. Neat.</p>
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
<?}


?>