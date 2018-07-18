<?
include_once "class.MegaDB.php";
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
        
        unset($user['hash']);

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
    
    //////////////////////////////////////// CONVENIENCE FUNCS:
    
    static function validEmail(string $email):bool {
        return preg_match("/^[a-zA-Z0-9\._]{4,20}@ferris\.edu$/", $email);
    }
    static function validPass($pass1, $pass2):bool {
        
        if($pass1 != $pass2) return ["err"=>"Your two passwords do NOT match."];
        
        if(strlen($pass1) < 8) return ["err"=>"Your password must be at least 8 characters."];
        
        //if(!preg_match('/^[a-zA-Z0-9\s\[\]\{\}\;:\'\"\<\>\.\,\?\`\~\!\@\#\$\%\^\&\*\(\)\_\-\+\=\/\\\\|]+$/', $pass)) return ["err"=>"Your password can't use non-ascii characters."];
        
        if(!preg_match('/[a-z]/', $pass1)) return ["err"=>"Your password must use at least one lowercase character."];
        if(!preg_match('/[A-Z]/', $pass1)) return ["err"=>"Your password must use at least one uppercase character."];
        if(!preg_match('/[0-9]/', $pass1)) return ["err"=>"Your password must use at least one number."];
        if(!preg_match('/[^a-zA-Z0-9\s]/', $pass1)) return ["err"=>"Your password must have at least one special character."];
    }
    static function doesExist($uid):bool{
        $uid = intval($uid);
        MegaDB::query("SELECT COUNT(*) AS 'check' FROM users WHERE id=?", array($uid));
        return ($rows[0]['check'] == 1);
    }
    
    //////////////////////////////////////// MANIPULATING OTHER USERS:
    
    static function resetPass($uid, $pass1, $pass2){
        
    }
    static function changePass($uid, $oldpass, $pass1, $pass2){
        
    }
    static function new($email, $pass, $first, $last, $alias, $title){

        if(!is_string($email)) $email = "";
        if(!is_string($pass)) $pass = "";
        if(!is_string($first)) $first = "";
        if(!is_string($last)) $last = "";
        if(!is_string($alias)) $alias = "";
        if(!is_string($title)) $title = "";

        ///////////////////////////////////// CHECK email:

        $email = strtolower($email);
        
        if(!User::validEmail($email))
            return ["err" => "Your email must be a Ferris email address."];

        $res = MegaDB::query('SELECT `id` FROM `users` WHERE `email`=?;', [$email]);
        
        if(count($res) > 0)
            return ["err" => "That email address is already registered."];

        ///////////////////////////////////// CHECK password:
        
        if(strlen($pass) < 8) return ["err"=>"Your password must be at least 8 characters."];
        
        //if(!preg_match('/^[a-zA-Z0-9\s\[\]\{\}\;:\'\"\<\>\.\,\?\`\~\!\@\#\$\%\^\&\*\(\)\_\-\+\=\/\\\\|]+$/', $pass)) return ["err"=>"Your password can't use non-ascii characters."];
        
        if(!preg_match('/[a-z]/', $pass)) return ["err"=>"Your password must use at least one lowercase character."];
        if(!preg_match('/[A-Z]/', $pass)) return ["err"=>"Your password must use at least one uppercase character."];
        if(!preg_match('/[0-9]/', $pass)) return ["err"=>"Your password must use at least one number."];
        if(!preg_match('/[^a-zA-Z0-9\s]/', $pass)) return ["err"=>"Your password must have at least one special character."];
        
        ///////////////////////////////////// MAKE HASH:
        
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        
        ///////////////////////////////////// INSERT:

        $values = array($alias, $title, $first, $last, $email, $hash);
        MegaDB::query("INSERT INTO `users` (`alias`,`title`,`first`,`last`,`email`,`hash`) VALUES(?, ?, ?, ?, ?, ?);", $values);
        
        return ["err" => ""];
    }
}
?>