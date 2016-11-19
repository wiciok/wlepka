<?php

require_once "connect_to_db.php";

if (isset($_COOKIE['login']) && isset($_COOKIE['token']))
{
    $cookieLogin=mysqli_real_escape_string($DB_link,trim($_COOKIE['login'],"'"));
    $cookieToken=mysqli_real_escape_string($DB_link,trim($_COOKIE['token'],"'"));

    //$data = mysqli_query($DB_link,"select login, token from users where login='$cookieLogin';");
    $data = mysqli_query($DB_link,"select users.login, current_sessions.token from users, current_sessions where current_sessions.id_user=users.id_user and users.login='$cookieLogin';");
    $row=mysqli_fetch_assoc($data);


    if($cookieToken!=$row['token'])
    {
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
        header('Location: loginpage.php');
    }

    else
    {
        if (basename($_SERVER['PHP_SELF'])!="mainpage.php")
            //echo "poprawne zalogowanie";
        header('Location: mainpage.php');
    }


    /*if ($row['login']!=$cookieLogin || $row['token'] != $cookieToken)
    {
        //only for debug //todo: usunac kiedy bedzie potrzeba
        echo "debug 1"."<br>";
        echo $cookieLogin."<br>";
        echo $cookieToken."<br>";

        //if($row['token'] != $cookieToken)
        //{
            //usuniecie starej sesji
       // }


        if (basename($_SERVER['PHP_SELF'])!="loginpage.php")
            echo "loginpage";
            //header('Location: loginpage.php');
    }
    else
    {
        if (basename($_SERVER['PHP_SELF'])!="mainpage.php")
            echo "poprawne zalogowanie";
            //header('Location: mainpage.php');
    }*/
}
else
{
    if (basename($_SERVER['PHP_SELF'])!="loginpage.php")
        //echo "brak cookie";
        header('Location: loginpage.php');
}
?>