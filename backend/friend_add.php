<?php
require_once "connect_to_db.php";
require_once "backend_logged_in_check.php";

$id_user=mysqli_real_escape_string($DB_link,$_COOKIE['id_user']);

if(isset($_POST['login']) && !empty($_POST['login']))
{
    $friend_login=mysqli_real_escape_string($DB_link,$_POST['login']);
    $data=mysqli_query($DB_link,"SELECT id_user FROM users WHERE login='$friend_login' LIMIT 1");
    $row=mysqli_fetch_assoc($data);

    if($row['id_user']!=$id_user)
    {
        $friend_id=$row['id_user'];
        mysqli_query($DB_link, "INSERT INTO friends(id_user_1, id_user_2, status) VALUES('$id_user','$friend_id','unconfirmed')");

        if(!mysqli_error($DB_link))
        {
            header('Location:'.$URL.'mainpage.php?page=friends&alert=1');
            exit;
        }
        else
        {
            echo mysqli_errno($DB_link);
            //echo mysqli_error($DB_link);

            if(mysqli_errno($DB_link)==1062)
                header('Location:'.$URL.'mainpage.php?page=friends&alert=6'); //blad - uzytkownicy sa juz znajomymi
            else
                header('Location:'.$URL.'mainpage.php?page=friends&alert=2'); //blad
            exit;
        }
    }

    else
    {
        header('Location:'.$URL.'mainpage.php?page=friends&alert=5'); //blad - proba bycia znajomym samego siebie
        exit;
    }
}

header('Location:'.$URL.'mainpage.php?page=friends&alert=2');
exit;


?>