<?php

require_once "connection_data.php";
$DB_link=mysqli_connect($DB_database_host,$DB_login,$DB_password,$DB_database_name,$DB_port)
or die("blad polaczenia z baza danych".mysqli_connect_error());


if(isset($_POST['login']) && !empty($_POST['login'] && isset($_POST['password']) && !empty($_POST['password'])))
{
    $login=mysqli_real_escape_string($DB_link,$_POST['login']);
    $password=mysqli_real_escape_string($DB_link,$_POST['password']);

    //only for debug: //todo: usunac kiedy bedzie zbedne
    echo "login:".$login."<br>";
    echo "haslo:".$password."<br>";;
    echo "sha256 z hasla:".hash("sha256",$password)."<br>";;


    //todo: dorobic transakcje albo inne blokowanie tabeli
    $data = mysqli_query($DB_link,"select login, passw from users where login='$login'");
    $row=mysqli_fetch_assoc($data);

    //todo: mozna dorobic solenie hasel
    if($row['login']==$login && $row['passw']==hash("sha256",$password))
    {
        setcookie('login', $login, false);
        setcookie('password', hash('sha256',$password), false);
        header('Location: mainpage.php');
    }
    else
    {
        echo "Błędny login i/lub hasło!"; //todo: usunac po zdebugowaniu
        //header('Location: loginpage.php');
    }
}
else
{
    echo "Login i/lub hasło nie wprowadzone!"; //todo: usunac po zdebugowaniu
    //header('Location: loginpage.php');
}

?>
