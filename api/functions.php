<?

function get(string $str){
    if(array_key_exists($str, $_GET)) return $_GET[$str];
    return '';
}
function post(string $str){
    if(array_key_exists($str, $_POST)) return $_POST[$str];
    return '';
}

?>