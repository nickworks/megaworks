<?php
include_once("includes/templates.php");
include_once("includes/class.Verify.php");

$email = post("email");
$message = empty($email) ? '' : Verify::open($email, true);

beginPage("");
mainMenu();
?>
<div class="tray darker">
    <? if(empty($email)){ ?>
    <h1>Reset your account</h1>
    <p>To reset your account, follow these easy steps:</p>
    <ul>
        <li>Below, type in the email address that is tied to your account.</li>
        <li>If your account exists, we'll send you an email.</li>
        <li>Click on the verification link in the email.</li>
        <li>Choose a new password for your account.</li>
        <li>Log in using your new password!</li>
    </ul>
    <form method="post" action="reset.php">
        <label>Email address</label>
        <input type="text" name="email">
        <input type="submit">
    </form>
    <? } else { ?>
    <h1>Check your inbox!</h1>
    <p>If we found you in our database, then you should receive an email from us soon!</p>
        <? if(isLocal()){ ?>
            <div class="hr"></div>
            <? if(!empty($message)){ ?>
            <p>Since you seem to be running this site locally, an email *probably* wasn't sent. But if it had, it would say:</p>
            <pre><?=$message?></pre>
            <? } else { ?>
            <p>Since you seem to be running this site locally, it's safe to let you know: that email address was NOT found in the database. Just FYI.</p>
            <? } ?>
        <? } ?>
    <? } ?>
</div>
<? endPage(); ?>