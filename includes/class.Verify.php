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
        
        return Verify::emailCode($email, $key);
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
    
    static function emailCode($email, $key){
        $url = "https://megaworks.org/verify.php?key=$key";
        $message='Hello, human!

This message is coming from your friends at megaworks.org. You are receiving this message because you\'ve requested to reset your account.

To verify your email address and reset your password, please <a href="'.$url.'">click here</a> OR copy and paste this link into your web browser: '.$url.'

Thanks!
The MEGA team';
        
        if(!isLocal()){
            mail($email, "MEGA // Verify your Account", $message, "from:auto@megaworks.org");
        }
        return $message; // mostly for debugging
    } // end emailCode()
}

?>