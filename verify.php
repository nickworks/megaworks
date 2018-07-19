<?php
include_once("includes/templates.php");
include_once("includes/class.Verify.php");

$key=get('key');
$res=Verify::lookup($key);
$keyValid = !empty($res);

if($keyValid){
    $pass1=post("password1");
    $pass2=post("password2");
    if(!empty($pass1)){ // form was submitted:
        $uid = $res[0]['id'];
        $errs = User::resetPass($uid, $pass1, $pass2);
    }
}


beginPage("");
mainMenu();
?>
<div class='tray darker'>
<? if($keyValid){ ?>
    <h1>Email Verified</h1>
    <? if(intval($res[0]['reset_password'])==1){ ?>
        <h2>You may now reset your password:</h2>
        <form action="verify.php?key=<?=$key?>">
            <label>New password:</label>
            <input type="password" name="password1">
            <label>Confirm new password:</label>
            <input type="password" name="password2">
            <input type="submit">
        </form>
    <? } else { ?>
        <h2>Your email has been verified, and you can now <a href="login.php">log in</a>.</h2>
    <? } ?>
<? } else { ?>
    <h1>Uh oh.</h1>
    <p>Your verification code is malformed, missing, or expired. <a href="reset.php">Send a new verification code</a>.</p>
<? } ?>
    
</div>
<? endPage(); ?>  