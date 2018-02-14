<?

function addThumbnail($image, $title = null){
    ?>

        <div class="thumbnail">
            <img src="<? echo $image; ?>">
            <? 
                if($title != null) echo "<h1>{$title}</h1>"; 
            ?>
        </div>

<?
}

function addComment($avatar, $comment){
    ?>
        <div class="comment">
            <div class="avatar">
                <img src="<? echo $avatar; ?>">
            </div>
            <div class="bubble">
                <p><? echo $comment; ?></p>
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
<?
}

function doThingMany($iter, string $function, array $params = null){
    while($iter > 0){
        $iter--;
        if($params != null)call_user_func_array($function, $params);
    }
}
?>