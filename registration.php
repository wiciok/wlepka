<?php
//todo: wysyłać komunikaty o poprawnej lub nie rejestracji za pomocą geta
require_once "connect_to_db.php";

if(isset($_POST['login']) && !empty($_POST['login'] && isset($_POST['password']) && !empty($_POST['password'])))
{
    $login=mysqli_real_escape_string($DB_link,$_POST['login']);

    if(mysqli_query($DB_link,"select login from users where login='$login'"))
    {
        header("location: loginpage.php?reg=2"); //login zajęty
    }

    $password=hash("sha256",$_POST['password'].$SALT);

    if(isset($_POST['name']) && !empty($_POST['name']))
        $name=mysqli_real_escape_string($DB_link,$_POST['name']);
    else
        $name='';

    if(isset($_POST['surname']) && !empty($_POST['surname']))
        $surname=mysqli_real_escape_string($DB_link,$_POST['surname']);
    else
        $surname='';

    mysqli_query($DB_link,"CALL pAddUser('$login','$password','$name','$surname');");

    if(mysqli_errno($DB_link))
    {
        /*echo "mysqli_errno: ".mysqli_errno($DB_link)."<br>";
        echo "mysqli_error: ".mysqli_error($DB_link)."<br>";
        echo "sql state : ".mysqli_sqlstate($DB_link)."<br>";*/
        header("location: loginpage.php?reg=99"); //błąd
    }
    else
        //echo "poprawnie utworzono konto";
        header("location: loginpage.php?reg=1");

}

else
{
    header("location: loginpage.php?reg=3");
}



?>