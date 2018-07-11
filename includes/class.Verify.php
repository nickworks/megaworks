<?php
include_once "includes/functions.php";
include_once "includes/class.CoolDB.php";

class Verify {
    // creates and returns new verification code
    static function open(int $uid, $pass_reset = false){
        if(!is_int($uid)) return false;
        $pass_reset=$pass_reset?1:0;
        $key=md5(rand(0,999999));
        $db=new CoolDB();
        $db->query("INSERT INTO user_verify_codes (id, user_id, code, expires, reset_password) VALUES(NULL,?,?,NOW() + INTERVAL 3 HOUR,?);", array($uid, $key, $pass_reset));
        return $key;
    }
    // returns true if a valid verification code exists
    static function check(string $key){
        $db = new CoolDB();
        $res=$db->query("SELECT * FROM user_verify_codes WHERE code=? AND expires>NOW();", array($key));
        return (count($res)>0);
    }
    // deletes matching (and expired) verification codes
    static function close(string $key){
        $db = new CoolDB();
        $res=$db->query("DELETE FROM user_verify_codes WHERE code=? OR expires<NOW();", array($key));
    }
}

?>