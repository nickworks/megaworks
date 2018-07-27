<?php
include_once("includes/templates.php");
include_once("includes/class.Verify.php");
include_once("includes/class.User.php");

$key=get('key');
$res=Verify::lookup($key);
$keyValid = !empty($res);
$isReset = true;
$errs = [];
$wasPasswordSet = false;

if($keyValid){
    
    $isReset = (intval($res[0]['reset_password'])==1);
    $uid = intval($res[0]['id']);
    
    if($isReset){
        $pass1=post("password1");
        $pass2=post("password2");
        if(!empty($pass1)){ // form was submitted:
            $errs = User::resetPass($key, $pass1, $pass2);
            if(empty($errs)) $wasPasswordSet = true;
        }
    } else {
        User::approve($uid);
        Verify::close($key);
    }
}


beginPage("");
mainMenu();
?>
<div class='tray darker'>
<? if($keyValid){ ?>
    <? if($isReset){ ?>
        <? if($wasPasswordSet){ ?>
            <h1>Password Changed</h1>
            <h2>You may now <a href="login.php">log in</a>.</h2>
        <? } else { ?>
            <h1>Email Verified</h1>
            <h2>You may now reset your password:</h2>
            <form action="verify.php?key=<?=$key?>" method="post">
                <? errors($errs); ?>
                <label>New password:</label>
                <input type="password" name="password1">
                <label>Confirm new password:</label>
                <input type="password" name="password2">
                <input type="submit">
            </form>
        <? } ?>
    <? } else { ?>
        <h1>Email Verified</h1>
        <h2>You may now <a href="login.php">log in</a>.</h2>
    <? } ?>
<? } else { ?>
    <h1>Uh oh.</h1>
    <p>Your verification code is malformed, missing, or expired. <a href="reset.php">Send a new verification code</a>.</p>
<? } ?>
    
</div>
<? endPage(); ?>  