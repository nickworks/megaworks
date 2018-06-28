<?php
$pass = $_GET['pass'];
$hash = password_hash($pass, PASSWORD_DEFAULT);
echo '<b>"'.$pass.'" hash:</b> ' . $hash;
echo "<br>";
echo "length: ".strlen($hash);
?>