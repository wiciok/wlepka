<?php

require_once "connect_to_db.php";
require_once "backend_logged_in_check.php";


function getPermissionId($DB_link, $perm_name) //tworzy jeśli potrzeba i zwraca id prawa dostępu x_user o danym shared_user_id
{
    if(isset($_POST['login']) && !empty($_POST['login']))
    {
        $shared_user_login=mysqli_real_escape_string($DB_link,$_POST['login']);
        $data=mysqli_query($DB_link,"SELECT id_user FROM users WHERE login='$shared_user_login'");
        if(mysqli_num_rows($data)!=1)
            throw new mysqli_sql_exception("user nie istnieje!");
        $row=mysqli_fetch_assoc($data);
        $shared_user_id=$row['id_user'];

        //sprawdzenie, czy user jest naszym znajomym
        $id_user=mysqli_real_escape_string($DB_link,$_COOKIE['id_user']);
        $data2=mysqli_query($DB_link,"
            SELECT id_user_1, id_user_2 
            FROM friends 
            WHERE ((id_user_1='$id_user' AND id_user_2='$shared_user_id')
            OR (id_user_2='$id_user' AND id_user_1='$shared_user_id'))
            AND friends.status='confirmed';
            ");
        if(mysqli_num_rows($data2)!=1)
            throw new LogicException("user o podanym id nie jest naszym potwierdzonym znajomym!");


        $data=mysqli_query($DB_link,"SELECT id_permission FROM permissions WHERE permission_name='$perm_name' AND id_shared_user='$shared_user_id'");
        if(mysqli_num_rows($data)==0)
        {
            mysqli_query($DB_link, "INSERT INTO permissions(permission_name, id_shared_user) VALUES('$perm_name','$shared_user_id')");
            $data=mysqli_query($DB_link,"SELECT id_permission FROM permissions WHERE permission_name='$perm_name' AND id_shared_user='$shared_user_id'");
        }
        else if(mysqli_error($DB_link))
            throw new mysqli_sql_exception("");

        $row=mysqli_fetch_assoc($data);

        return (int)$row['id_permission'];
    }

    else
        throw new Exception("Brak shared_user_id przesłanego metodą post");
}

if(isset($_POST['id_user']) && !empty($_POST['id_user']) && isset($_POST['id_file']) && !empty($_POST['id_file']))
{
    $id_user = mysqli_real_escape_string($DB_link, $_POST['id_user']);
    $id_file = mysqli_real_escape_string($DB_link, $_POST['id_file']);
}
else
{
    //echo "brak przeslanego w post id pliku!";
    header('Location:'.$URL.'mainpage.php');
    exit;
}

$retcode=0;
try
{
    $id_permission=0;

    if(isset($_POST['permission_type']) && !empty($_POST['permission_type']))
    {
        $permission_type=mysqli_real_escape_string($DB_link,$_POST['permission_type']);

        switch($permission_type)
        {
            case "read_friends":
                $id_permission=1;
                break;

            case "read_write_friends":
                $id_permission=2;
                break;

            case "read_all":
                $id_permission=3;
                break;

            case "read_user":
                $id_permission=getPermissionId($DB_link,'read_user');
                break;

            case "read_write_user":
                $id_permission=getPermissionId($DB_link,'read_write_user');
                break;

            default:
                throw new Exception("id_permission nie ustawione!");
                break;
        }
    }
    else
        throw new Exception("Brak permission_type przesłanego metodą post");

    //dodanie udostępnienia
    if(isset($_POST['id_user']) && !empty($_POST['id_user']))
    {
        $id_user = mysqli_real_escape_string($DB_link, $_POST['id_user']);
        $id_file = mysqli_real_escape_string($DB_link, $_POST['id_file']);

        mysqli_query($DB_link, "INSERT INTO shares(id_user, id_file, id_permission) VALUES('$id_user','$id_file','$id_permission')");

        if (mysqli_error($DB_link))
            throw new mysqli_sql_exception("blad dodawania udostepnienia" . mysqli_error($DB_link));
    }
    else
        throw new Exception("Brak id_user przesłanego metodą post");
}
catch(Exception $e)
{
    echo $e->getMessage();
    $retcode=8;
}

finally
{
    header('Location:'.$URL.'mainpage.php?page=file_properties&id_file='.$id_file.'&alert='.$retcode);
    exit;
}


?>