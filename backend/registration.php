<?php
require_once "connect_to_db.php";

if(isset($_POST['login']) && !empty($_POST['login'] && isset($_POST['password']) && !empty($_POST['password'])))
{
    $login=$_POST['login'];

    $login_pattern = '/^[\p{L}\p{N}_ ]{1,25}$/u';
    if(!preg_match($login_pattern,$login))
    {
        header('Location:'.$URL.'loginpage.php?reg=4'); //niedozwolone znaki w loginie
        exit;
    }

    $result=mysqli_query($DB_link,"select login from users where login='$login'");
    if(mysqli_num_rows($result)>0)
    {
        header('Location:'.$URL.'loginpage.php?reg=2'); //login zajęty
        exit;
    }

    $salt_unique=sha1(rand(0,255));
    $password=hash("sha256",addslashes($_POST['password']).$SALT.$salt_unique);

    if(isset($_POST['name']) && !empty($_POST['name']))
        $name=mysqli_real_escape_string($DB_link,$_POST['name']);
    else
        $name='';

    if(isset($_POST['surname']) && !empty($_POST['surname']))
        $surname=mysqli_real_escape_string($DB_link,$_POST['surname']);
    else
        $surname='';

    $name_pattern = '/^[\p{L}\p{N}_ ]{0,25}$/u';
    if(!preg_match($name_pattern,$name) || !preg_match($name_pattern,$surname))
    {
        header('Location:'.$URL.'loginpage.php?reg=5'); //niedozwolone znaki w imieniu/nazwisku
        exit;
    }



    mysqli_query($DB_link,"CALL pAddUser('$login','$password','$name','$surname','$salt_unique')");

    if(mysqli_errno($DB_link))
    {
        /*echo $salt_unique;
        echo "mysqli_errno: ".mysqli_errno($DB_link)."<br>";
        echo "mysqli_error: ".mysqli_error($DB_link)."<br>";
        echo "sql state : ".mysqli_sqlstate($DB_link)."<br>";*/
        header('Location:'.$URL.'loginpage.php?reg=99'); //błąd
        exit;
    }
    else
    {
        //echo "poprawnie utworzono konto";
        header('Location:'.$URL.'loginpage.php?reg=1');
        exit;
    }
}
else
{
    header('Location:'.$URL.'loginpage.php?reg=3');
    exit;
}
?>