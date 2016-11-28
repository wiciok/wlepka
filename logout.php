<?php
require_once "connect_to_db.php";

$cookieToken=mysqli_real_escape_string($DB_link,trim($_COOKIE['token'],"'"));
mysqli_query($DB_link,"CALL pRemSession('$cookieToken');");

if(isset($_COOKIE['id_user']))
{
    unset($_COOKIE['id_user']);
    setcookie('id_user', null, -1);
}

if(isset($_COOKIE['token']))
{
    unset($_COOKIE['token']);
    setcookie('token', null, -1);
}

header("Location: index.php");
exit;

?>