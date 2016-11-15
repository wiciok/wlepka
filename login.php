<!DOCTYPE html>
<html>
<?php

require_once "connection_data.php";
$link=mysqli_connect($database_host,$login,$password,$database_name,$port)
or die("blad polaczenia z baza danych".mysqli_connect_error());


if(isset($_POST['login']) && !empty($_POST['login'] && isset($_POST['password']) && !empty($_POST['password'])));
{
    echo "login:".$_POST['login']."<br>";
    echo "haslo:".$_POST['password'];

    /*$data = mysqli_query($link,"select login from users where login=$POST['login']");*/
    $wiersz=mysqli_fetch_assoc($data);
    echo $wiersz['login'];

    /*if($_POST['login'])

    header('Location: mainpage.php');*/
}

else
{
    /*header('Location: index.php');*/
}

?>
</html>
