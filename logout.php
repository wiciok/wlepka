<?php
require_once "connect_to_db.php";
//todo: zmienic zawartosc cookie na id usera zamiast loginu
$cookieLogin=mysqli_real_escape_string($DB_link,trim($_COOKIE['login'],"'"));
$cookieToken=mysqli_real_escape_string($DB_link,trim($_COOKIE['token'],"'"));
mysqli_query($DB_link,"CALL pRemSession('$cookieToken');");

if(isset($_COOKIE['login']))
{
    unset($_COOKIE['login']);
    setcookie('login', null, -1);
}

if(isset($_COOKIE['token']))
{
    unset($_COOKIE['token']);
    setcookie('token', null, -1);
}

header("Location: index.php");
exit;

?>