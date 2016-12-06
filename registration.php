<?php
require_once "connect_to_db.php";

if(isset($_POST['login']) && !empty($_POST['login'] && isset($_POST['password']) && !empty($_POST['password'])))
{
    $login=mysqli_real_escape_string($DB_link,$_POST['login']);

    $result=mysqli_query($DB_link,"select login from users where login='$login'");
    if(mysqli_num_rows($result)>0)
    {
        header("location: loginpage.php?reg=2"); //login zajęty
        exit;
    }

    $salt_unique=sha1(rand(0,255));
    $password=hash("sha256",$_POST['password'].$SALT.$salt_unique);

    if(isset($_POST['name']) && !empty($_POST['name']))
        $name=mysqli_real_escape_string($DB_link,$_POST['name']);
    else
        $name='';

    if(isset($_POST['surname']) && !empty($_POST['surname']))
        $surname=mysqli_real_escape_string($DB_link,$_POST['surname']);
    else
        $surname='';

    mysqli_query($DB_link,"CALL pAddUser('$login','$password','$name','$surname','$salt_unique')");

    if(mysqli_errno($DB_link))
    {
        /*echo $salt_unique;
        echo "mysqli_errno: ".mysqli_errno($DB_link)."<br>";
        echo "mysqli_error: ".mysqli_error($DB_link)."<br>";
        echo "sql state : ".mysqli_sqlstate($DB_link)."<br>";*/
        header("location: loginpage.php?reg=99"); //błąd
        exit;
    }
    else
    {
        //echo "poprawnie utworzono konto";
        header("location: loginpage.php?reg=1");
        exit;
    }
}
else
{
    header("location: loginpage.php?reg=3");
    exit;
}
?>