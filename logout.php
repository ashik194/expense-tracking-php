<?php
session_start();

$_SESSION = array();

session_destroy();

foreach ($_COOKIE as $key => $value) {
    setcookie($key, '', time() - 3600, '/', '', false, true);
}

header("Location: index.php");
exit;
?>