<?php

require_once "connection_data.php";

$DB_link=mysqli_connect($DB_database_host,$DB_login,$DB_password,$DB_database_name,$DB_port)
or die("blad polaczenia z baza danych".mysqli_connect_error());

if (isset($_COOKIE['login']) && isset($_COOKIE['token']))
{
    $cookieLogin=mysqli_real_escape_string($DB_link,trim($_COOKIE['login'],"'"));
    $cookieToken=mysqli_real_escape_string($DB_link,trim($_COOKIE['token'],"'"));

    //TODO: KONIECZNIE!!! poprawic kwestie logowania sie 2 razy na 1 konto - obecnie bug, blokada uzytkownika
    //$data = mysqli_query($DB_link,"select login, token from users where login='$cookieLogin';");
    $data = mysqli_query($DB_link,"select users.login, current_sessions.token from users, current_sessions where current_sessions.id_user=users.id_user and login='$cookieLogin';");
    $row=mysqli_fetch_assoc($data);


    if ($row['token'] != $cookieToken)
    {
        //only for debug //todo: usunac kiedy bedzie potrzeba
        /*echo "debug 1";
        echo $row['passw']."<br>";
        echo $cookiePassword."<br>";*/

        if (basename($_SERVER['PHP_SELF'])!="loginpage.php")
            header('Location: loginpage.php');
    }
    else
    {
        if (basename($_SERVER['PHP_SELF'])!="mainpage.php")
            header('Location: mainpage.php');
    }
}
else
{
    if (basename($_SERVER['PHP_SELF'])!="loginpage.php")
        header('Location: loginpage.php');
}
?>