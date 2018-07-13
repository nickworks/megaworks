<?

function isLocal(){
    return $_SERVER['SERVER_ADDR'] === $_SERVER['REMOTE_ADDR'];
}
function easyDate($mysql){
    return date('M d @ h:i a', strtotime($mysql));
}
function array_key($arr, $key){
    return array_key_exists($key, $arr) ? $arr[$key] : '';
}
function get(string $str){
    $res=array_key($_GET, $str);
    if (get_magic_quotes_gpc()) $res=stripslashes($res);
    return $res;
}
function post(string $str){
    $res=array_key($_POST, $str);
    if (get_magic_quotes_gpc()) $res=stripslashes($res);
    return $res;
}
function formData(string $key){
    return htmlentities(post($key));
}

?>