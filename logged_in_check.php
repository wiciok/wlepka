<?php

require_once "connect_to_db.php";

header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0, max-age=0", false);
header("Pragma: no-cache");

if (isset($_COOKIE['id_user']) && isset($_COOKIE['token']))
{
    $cookieID_user=mysqli_real_escape_string($DB_link,trim($_COOKIE['id_user'],"'"));
    $cookieToken=mysqli_real_escape_string($DB_link,trim($_COOKIE['token'],"'"));

    $data = mysqli_query($DB_link,"select current_sessions.id_user, current_sessions.token from current_sessions where current_sessions.id_user='$cookieID_user' and current_sessions.token='$cookieToken'");

    if(mysqli_num_rows($data)!=1)
    {
        //usuniecie ciastek
        unset($_COOKIE['id_user']);
        setcookie('id_user', null, -1);
        unset($_COOKIE['token']);
        setcookie('token', null, -1);
        
        if (basename($_SERVER['PHP_SELF'])!="loginpage.php")
        {
            //echo "brak obecnie zalogowanego uzytkownika o danym id i tokenie";
            header('Location: loginpage.php');
            exit;
        }
    }

    else
    {
        if (basename($_SERVER['PHP_SELF'])!="mainpage.php")
        {
            //echo "poprawne zalogowanie";
            header('Location: mainpage.php');
            exit;
        }
    }
}
else
{
    if (basename($_SERVER['PHP_SELF'])!="loginpage.php")
    {
        //echo "brak cookie";
        header('Location: loginpage.php');
        exit;
    }
}
?>