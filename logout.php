<?php

if(isset($_COOKIE['login']))
{
    unset($_COOKIE['login']);
    setcookie('login', null, -1);
}

if(isset($_COOKIE['password']))
{
    unset($_COOKIE['password']);
    setcookie('password', null, -1);
}

header("Location: index.php");

?>