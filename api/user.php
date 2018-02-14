<?
include "functions.php";
include "CoolDB.php";

class User {
    
    const ROLE_ADMIN = 1;
    const ROLE_MOD = 2;
    const ROLE_USER = 3;
    
    private static $current;
    private static function setCurrent(array $row){
        
        $user = $row;        
        $uid = intval($user['id']);
        
        if($uid == 0) return;
        
        unset($user['hash']);
        unset($user['salt']);

        if(session_status() !== PHP_SESSION_ACTIVE) session_start();
        $_SESSION['userid'] = $uid;
        User::$current = $user;
    }
    static function current(){
        
        if(!empty(User::$current)) return User::$current;
        
        if(session_status() !== PHP_SESSION_ACTIVE) session_start();
        //if(array_key_exists('user', $_SESSION)) return $_SESSION['user'];
        if(array_key_exists('userid', $_SESSION)) {
            $id = intval($_SESSION['userid']);
            $db = new CoolDB();
            $res = $db->table('users')->select()->where(['id' => $id])->execute();
            if(count($res) > 0) {
                User::setCurrent($res[0]);
                return User::$current;
            }            
        }
        unset($_SESSION['userid']);
        return null;
    }
    
    static function logout(){
        if(session_status() !== PHP_SESSION_ACTIVE) session_start();
        unset($_SESSION['user']);
    }
    static function login(string $email, string $pass){
        $db = new CoolDB();
        $db->table('users');
        $res = $db->select()->where(['email' => $email])->execute();
        if(count($res) < 1) return ["err" => "Couldn't find that email address."];

        $user = $res[0];

        $salt = $user['salt'];
        $hash = $user['hash'];

        if(md5($pass.$salt) !== $hash) return ["err" => "Password incorrect"];

        User::setCurrent($user);

        return ["err"=>""];
    }   
    
    static function isAdmin():bool{
        $user = User::current();
        if(!is_array($user)) return false;
        if(!array_key_exists('role', $user)) return false;
        $role = intval($user['role']);
        
        return ($role === User::ROLE_ADMIN);
    }
    static function isMod():bool {
        $user = User::current();
        if(!is_array($user)) return false;
        if(!array_key_exists('role', $user)) return false;
        $role = intval($user['role']);
        return ($role === User::ROLE_ADMIN || $role === User::ROLE_MOD);
    }
    
    static function approve($id){
        
    }
    static function new($email, $pass, $first, $last, $alias, $title){

        if(!is_string($email)) $email = "";
        if(!is_string($pass)) $pass = "";
        if(!is_string($first)) $first = "";
        if(!is_string($last)) $last = "";
        if(!is_string($alias)) $alias = "";
        if(!is_string($title)) $title = "";
        
        $db = new CoolDB();
        $db->table('users');

        ///////////////////////////////////// CHECK email:

        $email = strtolower($email);
        
        if(!preg_match("/^[a-zA-Z0-9\._]{4,20}@ferris\.edu$/", $email))
            return ["err" => "Your email must be a Ferris email address."];

        //$res = $db->select('id')->where(['email' => $email])->execute();
        $res = $db->query('SELECT `id` FROM `users` WHERE `email`=?', [$email]);
        
        if(count($res) > 0)
            return ["err" => "That email address is already registered."];

        ///////////////////////////////////// CHECK password:
        
        if(strlen($pass) < 8) return ["err"=>"Your password must be at least 8 characters."];
        
        if(!preg_match('/^[a-zA-Z0-9\s\[\]\{\}\;:\'\"\<\>\.\,\?\`\~\!\@\#\$\%\^\&\*\(\)\_\-\+\=\/\\\\|]+$/', $pass)) return ["err"=>"Your password can't use non-ascii characters."];
        
        if(!preg_match('/[a-z]/', $pass)) return ["err"=>"Your password must use at least one lowercase character."];
        if(!preg_match('/[A-Z]/', $pass)) return ["err"=>"Your password must use at least one uppercase character."];
        if(!preg_match('/[0-9]/', $pass)) return ["err"=>"Your password must use at least one number."];
        
        ///////////////////////////////////// MAKE HASH:

        $salt = rand(10000, 99999);
        $hash = md5($pass.$salt);

        ///////////////////////////////////// INSERT:

        $values = [
            'alias' => $alias,
            'title' => $title,
            'first' => $first,
            'last' =>  $last,
            'email' => $email,
            'hash' => $hash,
            'salt' => $salt,
            'approved' => false
        ];

        $db->insert($values)->execute();
        return ["err" => ""];
    }
}
?>