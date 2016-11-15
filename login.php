<!DOCTYPE html>
<html>
<?php

require_once "connection_data.php";
$DB_link=mysqli_connect($DB_database_host,$DB_login,$DB_password,$DB_database_name,$DB_port)
or die("blad polaczenia z baza danych".mysqli_connect_error());


if(isset($_POST['login']) && !empty($_POST['login'] && isset($_POST['password']) && !empty($_POST['password'])))
{
    $login=mysqli_real_escape_string($DB_link,$_POST['login']);
    $password=mysqli_real_escape_string($DB_link,$_POST['password']);

    echo "login:".$login."<br>";
    echo "haslo:".$password;

    $data = mysqli_query($DB_link,"select login, passw from users where login='$login'");
    $row=mysqli_fetch_assoc($data);
    if($row['login']==$login && $row['passw']==$password) #toDo: dorobic haszowanie sha-2 po zrobieniu rejestracji
    {



        header('Location: mainpage.php');
    }

}

else
{
    header('Location: index.php');
}

?>
</html>
