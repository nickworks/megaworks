<?php
include_once "includes/functions.php";
include_once "includes/class.MegaDB.php";

class Verify {
    
    const MSG_FORGOT = 'Hello, human!\n\nThis message is coming from your friends at megaworks.org. You are receiving this message because you\'ve requested to reset your account.\n\nTo verify your email address and reset your password';
    
    const MSG_SIGNUP = 'Hello, human!\n\nThanks for signing up for megaworks.org. You are receiving this message so that we may verify your email address.\n\nTo verify your email address and complete the registration process';
    
    // creates and returns new verification code
    static function open(string $email, $pass_reset = false){
        
        $res=MegaDB::query("SELECT * FROM users WHERE email=?;",array($email));
        if(empty($res)) return;
        $uid = $res[0]['id'];        
        if(!is_numeric($uid)) return;
        
        $pass_reset=$pass_reset?1:0;
        $key=bin2hex(random_bytes(16)); // make a random key
        
        MegaDB::query("INSERT INTO user_verify_codes (id, user_id, code, expires, reset_password) VALUES(NULL,?,?,NOW() + INTERVAL 3 HOUR,?);", array($uid, $key, $pass_reset));
        
        return Verify::emailCode($email, $key, $pass_reset);
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
    // sends a verification code to the specified email addres
    private static function emailCode($email, $key, $pass_reset = false){
        $url = "https://www.megaworks.org/verify.php?key=$key";
        
        $message = $pass_reset ? Verify::MSG_FORGOT : Verify::MSG_SIGNUP;

        $message .= ', please <a href="'.$url.'">click here</a> OR copy and paste this link into your web browser: '.$url.' \n\nThanks!\nThe MEGA team';
        
        if(!isLocal()){
            mail($email, "MEGA // Verify your Account", $message, "from:auto@megaworks.org");
        }
        return $message; // mostly for debugging
    } // end emailCode()
}

?>