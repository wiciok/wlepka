<?php

//todo: mozna nawiazywanie polaczenia z baza wydzielic do osobnego pliku
require_once "connection_data.php";
$DB_link=mysqli_connect($DB_database_host,$DB_login,$DB_password,$DB_database_name,$DB_port)
or die("blad polaczenia z baza danych".mysqli_connect_error());

$cookieLogin=mysqli_real_escape_string($DB_link,trim($_COOKIE['login'],"'"));
$cookieToken=mysqli_real_escape_string($DB_link,trim($_COOKIE['token'],"'"));
//mysqli_query($DB_link, "UPDATE users SET token='' WHERE login='$cookieLogin';");
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

?>