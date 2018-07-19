<?
include_once "class.MegaDB.php";
include_once "class.Verify.php";
include_once "functions.php";

User::sessionStart();

/**
 * This class provides simple methods for interacting with user model.
 */
class User {
    
    //////////////////////////////////////// WORKING W/ THE "CURRENT USER":
    
    private static $current;
    private static function setCurrent(array $row){
        
        $user = $row;        
        $uid = intval($user['id']);
        
        if($uid == 0) return;
        
        //unset($user['hash']);

        $_SESSION['userid'] = $uid;
        User::$current = $user;
    }
    static function sessionStart(){
        if(session_status() !== PHP_SESSION_ACTIVE)
            session_start([
                'cookie_httponly' => true,
                //'cookie_secure' => true //???
            ]);
    }
    static function current(){
        if(!empty(User::$current)) return User::$current;

        //if(array_key_exists('user', $_SESSION)) return $_SESSION['user'];
        if(array_key_exists('userid', $_SESSION)) {
            $id = intval($_SESSION['userid']);            
            $res = MegaDB::query("SELECT * FROM `users` WHERE `id`=?;", array($id));
            
            if(count($res) > 0) {
                User::setCurrent($res[0]);
                return User::$current;
            }            
        }
        unset($_SESSION['userid']);
        return null;
    }
    static function logout(){
        unset($_SESSION['userid']);
    }
    static function login(string $email, string $pass){
        $res = MegaDB::query("SELECT * FROM `users` WHERE `email`=?;", array($email));
        
        if(count($res) < 1) return ["err" => "Couldn't find that email address."];

        $user = $res[0];
        $hash = $user['hash'];

        if(!password_verify($pass, $hash)) return ["err" => "Password incorrect"];

        User::setCurrent($user);

        return ["err"=>""];
    }   
    static function isLoggedIn():bool {
        $user = User::current();
        return (!empty($user));
    }
    static function avatar($user):string{
        $default = "imgs/placeholder-avatar1.jpg";
        $email = "";
        if(is_string($user)) $email = $user;
        if(is_array($user) && array_key_exists('email', $user)) $email = $user['email'];
        if(empty($email)) return $default;
        $url = "media/avatars/$email.png";
        return file_exists($url) ? $url : $default;
    }
    static function isAdmin():bool {
        $user = User::current();
        if(!is_array($user)) return false;
        if(!array_key_exists('is_admin', $user)) return false;  
        return ($user['is_admin'] === '1');
    }
    static function isMod():bool {
        $user = User::current();
        if(!is_array($user)) return false;
        if(!array_key_exists('is_mod', $user)) return false;
        return ($user['is_mod'] === '1');
    }
    static function isApproved():bool {
        $user = User::current();
        if(!is_array($user)) return false;
        if(!array_key_exists('is_approved', $user)) return false;
        return ($user['is_approved'] === '1');
    }
    static function changePass($oldpass, $pass1, $pass2){
        
        $user = User::current();
        
        if(empty($user)) return ['You must be logged in to change your password.'];
        if(!password_verify($oldpass, $user['hash'])) return ["Your old password is incorrect."];
        
        $errs = User::validPass($pass1, $pass2);
        if(!empty($errs)) return $errs;
        
        $hash=User::hash($pass1);
        $uid = intval($user['id']);
        
        MegaDB::query("UPDATE `users` SET `hash`=? WHERE id=?;", array($hash, $uid));
        
        $errCode = intval(MegaDB::errs()); // convert error code into int, if it's not 0:
        if(!empty($errCode)) return ["Uh oh. Something went wrong on our end. Please let us know so we can fix it. Error code: $errCode"];
        
        return [];
    }
    
    //////////////////////////////////////// CONVENIENCE FUNCS:
    
    static function validEmail(string $email):bool {
        return preg_match("/^[a-zA-Z0-9\._]{4,20}@ferris\.edu$/", $email);
    }
    static function validPass($pass1, $pass2):array {
        
        $errs = array();
        if($pass1 != $pass2) array_push($errs, "Your two passwords do NOT match.");
        if(strlen($pass1) < 8) array_push($errs, "Your password must be at least 8 characters.");
        if(!preg_match('/[a-z]/', $pass1)) array_push($errs, "Your password must use at least one lowercase character.");
        if(!preg_match('/[A-Z]/', $pass1)) array_push($errs, "Your password must use at least one uppercase character.");
        if(!preg_match('/[0-9]/', $pass1)) array_push($errs, "Your password must use at least one number.");
        if(!preg_match('/[^a-zA-Z0-9\s]/', $pass1)) array_push($errs, "Your password must have at least one special character.");
        //if(!preg_match('/^[a-zA-Z0-9\s\[\]\{\}\;:\'\"\<\>\.\,\?\`\~\!\@\#\$\%\^\&\*\(\)\_\-\+\=\/\\\\|]+$/', $pass)) array_push($errs, "Your password can't use non-ascii characters.");
        return $errs;
    }
    static function doesExist($uid):bool{
        $uid = intval($uid);
        MegaDB::query("SELECT COUNT(*) AS 'check' FROM users WHERE id=?", array($uid));
        return ($rows[0]['check'] == 1);
    }
    static function hash($pass){
        return password_hash($pass, PASSWORD_DEFAULT);
    }
    
    //////////////////////////////////////// MANIPULATING OTHER USERS:
    
    static function resetPass(string $key, string $pass1, string $pass2){
        $errs = array();
        
        if(!is_string($key)) $key = "";
        if(!is_string($pass1)) $pass1 = "";
        if(!is_string($pass2)) $pass2 = "";
        
        $res = Verify::lookup($key); // get user matching verification key
        if(empty($res)) return ["Verification key invalid."];
        
        $errs = array_merge($errs, User::validPass($pass1, $pass2));
        if(!empty($errs)) return $errs; // FAIL
        
        $hash = User::hash($pass1);
        $uid = intval($res[0]['user_id']);
        $res = MegaDB::query("UPDATE `users` SET `hash`=? WHERE id=?;", [$hash, $uid]);
        
        $errCode = intval(MegaDB::errs()); // convert error code into int, if it's not 0:
        if(!empty($errCode)) return ["Uh oh. Something went wrong on our end. Please let us know so we can fix it. Error code: $errCode"];
        
        Verify::close($key); // close verification code (delete from DB)
        
        return [];
    }
    static function new($email, $pass1, $pass2, $first, $last){

        $errs = array();
        
        if(!is_string($email)) $email = "";
        if(!is_string($pass1)) $pass1 = "";
        if(!is_string($pass2)) $pass2 = "";
        if(!is_string($first)) $first = "";
        if(!is_string($last)) $last = "";

        ///////////////////////////////////// CHECK email:

        $email = strtolower($email); 
        if(!User::validEmail($email)) {
            array_push($errs, "Your email must be a Ferris email address.");
        } else {
            $res = MegaDB::query('SELECT `id` FROM `users` WHERE `email`=?;', [$email]);
            if(count($res) > 0) array_push($errs, "That email address is already registered.");
        }
        ///////////////////////////////////// CHECK password:
        
        $errs = array_merge($errs, User::validPass($pass1, $pass2));
        
        if(!empty($errs)) return $errs; // FAIL
                                         
        ///////////////////////////////////// MAKE HASH:
        
        $hash = User::hash($pass1);
        
        ///////////////////////////////////// INSERT:

        $values = array('', 'Newbie', $first, $last, $email, $hash);
        MegaDB::query("INSERT INTO `users` (`alias`,`title`,`first`,`last`,`email`,`hash`) VALUES(?, ?, ?, ?, ?, ?);", $values);
        
        return $errs;
    }
}
?>