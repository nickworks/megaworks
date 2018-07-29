<?php
include_once "includes/functions.php";
include_once "includes/class.MegaDB.php";

class Verify {
    
    // creates and returns new verification code
    static function open(string $email, $pass_reset = false){
        
        $res=MegaDB::query("SELECT * FROM users WHERE email=?;",array($email));
        if(empty($res)) return;
        $uid = $res[0]['id'];        
        if(!is_numeric($uid)) return;
        
        $pass_reset=$pass_reset?1:0;
        $key=bin2hex(random_bytes(16)); // make a random key
        
        MegaDB::query("INSERT INTO user_verify_codes (id, user_id, code, expires, reset_password) VALUES(NULL,?,?,NOW() + INTERVAL 3 HOUR,?);", array($uid, $key, $pass_reset));
        
        return Mail::sendKey($email, $key, $pass_reset);
    }
    // returns matching row if a valid verification code exists
    static function lookup(string $key){
        if(empty($key)||!is_string($key))return false;
        
        return MegaDB::query("SELECT * FROM user_verify_codes WHERE code=? AND expires>NOW();", array($key));
    }
    // deletes matching (and expired) verification codes
    static function close(string $key){
        
        $res=MegaDB::query("DELETE FROM user_verify_codes WHERE code=? OR expires<NOW();", array($key));
    }
}

class Mail {
     
    static function send($to, $msg_text, $msg_html){
        $split = uniqid("");
        $rn = "\r\n";
        $headers = implode($rn, [
            'MIME-Version: 1.0',
            'Content-type: multipart/alternative;boundary='.$split,
            'From: MEGA <auto@megaworks.org>',
            'Reply-To: mega.gr@ferris.edu',
            'X-Mailer: PHP/'.phpversion()
        ]);
        
        $message = "$rn$rn--$split{$rn}Content-type:text/plain;charset=utf-8$rn$rn";
        $message.= $msg_txt;
        $message.= "$rn$rn--$split{$rn}Content-type:text/html;charset=utf-8$rn$rn";
        $message.= $msg_html;
        $message.= "$rn$rn--$split--";
        
        mail($to, "Account Verification", $message, $headers);
    }
    static function sendKey($to, $key, $forgot){
        $url = "https://www.megaworks.org/verify.php?key=$key";
        
        $msg_html = ($forgot)
            ? '<!doctype html><html><body><p>Hello, human!</p><p>This message is coming from your friends at megaworks.org. You are receiving this message because you\'ve requested to reset your account.</p><p>To verify your email address and reset your password, please click or copy the following link: <a href="'.$url.'">'.$url.'</a> </p> <p>Thanks!<br>The MEGA team</p></body></html>'
            : '<!doctype html<html><body><p>Hello, human!</p><p>Thanks for signing up for megaworks.org. You are receiving this message so that we may verify your email address.</p><p>To verify your email address and complete the registration process, please click or copy the following link: <a href="'.$url.'">'.$url.'</a> </p> <p>Thanks!<br>The MEGA team</p></body></html>';
        
        $msg_text = ($forgot)
            ? 'Hello, human!\r\nThis message is coming from your friends at megaworks.org. You are receiving this message because you\'ve requested to reset your account.\r\n\r\nTo verify your email address and reset your password, please click or copy the following link: '.$url.' \r\n\r\nThanks!\r\nThe MEGA team'
            : 'Hello, human!\r\nThanks for signing up for megaworks.org. You are receiving this message so that we may verify your email address.\r\n\r\nTo verify your email address and complete the registration process, please click or copy the following link: '.$url.' \r\n\r\nThanks!\r\nThe MEGA team';
        
        Mail::send($to, $msg_text, $msg_html);
    }
}
?>