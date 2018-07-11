<?php
include_once("includes/templates.php");
include_once("includes/class.Verify.php");

$key=get('key');
$res=Verify::check($key);
$keyValid = !empty($res);

beginPage("");
mainMenu();
?>
<div class='tray darker'>
<? if($keyValid){ ?>
    <h1>Email Verified</h1>
    <? if(intval($res[0]['reset_password'])==1){ ?>
    <h2>You may now reset your password:</h2>
    <form>
        <input type="password" name="password1">
        <input type="password" name="password2">
    </form>
    <? } ?>
<? } else { ?>
    <p>Malformed, missing, or expired verification code.</p>
<? } ?>
    
</div>
<? endPage(); ?>  