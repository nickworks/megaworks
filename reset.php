<?php
include_once("includes/templates.php");
include_once("includes/class.Verify.php");

$message='';
$email = post("email");
if(!empty($email)){
    // lookup user
    $db=new CoolDB();
    $res=$db->query("SELECT * FROM users WHERE email=?;",array($email));
    if(!empty($res)){
        $email = $res[0]['email'];
        $uid = $res[0]['id'];
        
        // create a verification code
        $key = Verify::open($uid, true);
        $url = "https://megaworks.org/verify.php?key=$key";
        
        $message='
Hello, human!

This message is coming from your friends at megaworks.org. You are receiving this message because you\'ve requested to reset your account.

To verify your email address and reset your password, please <a href="'.$url.'">click here</a> OR copy and paste this link into your web browser: '.$url.'

Thanks!
The MEGA team';
        
        if(!isLocal()){
            mail($email, "MEGA // Verify your Account", $message, "from:auto@megaworks.org");
        }
    }
}



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