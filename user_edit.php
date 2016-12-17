<?php
require_once "connect_to_db.php";

$logged_id_user=mysqli_real_escape_string($DB_link,$_COOKIE['id_user']);


if(isset($_POST['login']) && !empty($_POST['login']))
{
    $login=mysqli_real_escape_string($DB_link, $_POST['login']);
    $input_pattern = '/^[\p{L}\p{N}_ ]{1,25}$/u';
    if(!preg_match($input_pattern,$login))
    {
        header("location: mainpage.php?page=profileedit&alert=4"); //niedozwolone znaki w loginie lub za długi
        exit;
    }
    $result=mysqli_query($DB_link,"SELECT login FROM users WHERE login='$login'");

    if(mysqli_num_rows($result)>0)
    {
        header('Location: mainpage.php?page=profileedit&alert=3');
        exit;
    }
    else
    {
        mysqli_query($DB_link,"UPDATE users SET login='$login' WHERE id_user=$logged_id_user");
    }
}

if(isset($_POST['password']) && !empty($_POST['password']))
{
    $password=hash("sha256",$_POST['password'].$SALT);
    mysqli_query($DB_link,"UPDATE users SET passw='$password' WHERE id_user=$logged_id_user");
}

if(isset($_POST['name']) && !empty($_POST['name']))
{
    $name=mysqli_real_escape_string($DB_link, $_POST['name']);
    $input_pattern = '/^[\p{L}\p{N}_ ]{1,25}$/u';
    if(!preg_match($input_pattern,$name))
    {
        header("location: mainpage.php?page=profileedit&alert=4"); //niedozwolone znaki lub za dlugi
        exit;
    }
    mysqli_query($DB_link,"UPDATE users SET name='$name' WHERE id_user=$logged_id_user");
}

if(isset($_POST['surname']) && !empty($_POST['surname']))
{
    $surname=mysqli_real_escape_string($DB_link, $_POST['surname']);
    $input_pattern = '/^[\p{L}\p{N}_ ]{1,25}$/u';
    if(!preg_match($input_pattern,$surname))
    {
        header("location: mainpage.php?page=profileedit&alert=4"); //niedozwolone znaki lub za dlugi
        exit;
    }
    mysqli_query($DB_link,"UPDATE users SET surname='$surname' WHERE id_user=$logged_id_user");
}

if(isset($_POST['country']) && !empty($_POST['country']))
{
    $country_name=mysqli_real_escape_string($DB_link,$_POST['country']);
    $input_pattern = '/^[\p{L}\p{N}_ ]{1,25}$/u';
    if(!preg_match($input_pattern,$country_name))
    {
        header("location: mainpage.php?page=profileedit&alert=4"); //niedozwolone znaki lub za dlugi
        exit;
    }

    $data=mysqli_query($DB_link,"SELECT name FROM countries WHERE name='$country_name'");
    if(mysqli_num_rows($data)==0)
    {
        mysqli_query($DB_link,"INSERT INTO countries(name) VALUES('$country_name')");
    }
    mysqli_query($DB_link,"UPDATE users SET id_country=(SELECT id_country FROM countries WHERE name='$country_name')");

}

if(isset($_POST['birth_date']) && !empty($_POST['birth_date']))
{
    $birth_date=mysqli_real_escape_string($DB_link, $_POST['birth_date']);
    mysqli_query($DB_link,"UPDATE users SET birth_date='$birth_date' WHERE id_user=$logged_id_user");
}

if(isset($_POST['city']) && !empty($_POST['city']))
{
    $city=mysqli_real_escape_string($DB_link, $_POST['city']);
    mysqli_query($DB_link,"UPDATE users SET city='$city' WHERE id_user=$logged_id_user");
}



if(mysqli_error($DB_link))
{
    //echo mysqli_errno($DB_link);
    //echo mysqli_error($DB_link);
    header('Location: mainpage.php?page=profileedit&alert=2');
    exit;
}
else
{
    header('Location: mainpage.php?page=profileedit&alert=1');
    exit;
}


?>