<?php
require_once "connect_to_db.php";

$response='error';

if(isset($_POST['login']) && !empty($_POST['login']))
{
    $response='true';
    //$response=$_POST['login'];

    $login_pattern = '/^[\p{L}\p{N}_ ]{1,25}$/u'; //tak samo jak w registration.php
    if(!preg_match($login_pattern,$_POST['login']))
    {
        $response='false';
        exit;
    }

    $login=$_POST['login'];
    $data=mysqli_query($DB_link,"SELECT login FROM users WHERE login='$login'");

    if(mysqli_num_rows($data)!=0)
    {
        $response='false';
    }
}

echo $response;

mysqli_close($DB_link);
?>