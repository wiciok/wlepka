<?php
require_once "connect_to_db.php";

if(isset($_POST['id_user_1']) && !empty($_POST['id_user_1']) && isset($_POST['id_user_2']) && !empty($_POST['id_user_2'])) {
    $id_1 = mysqli_real_escape_string($DB_link, $_POST['id_user_1']);
    $id_2 = mysqli_real_escape_string($DB_link, $_POST['id_user_2']);


    mysqli_query($DB_link, "DELETE FROM friends WHERE friends.id_user_1='$id_1' AND friends.id_user_2='$id_2'");

    if (!mysqli_error($DB_link))
    {
        header("location: mainpage.php?page=friends&alert=7");
        exit;
    }
    else
    {
        //echo mysqli_error($DB_link);
        header("location: mainpage.php?page=friends&alert=8"); //blad
        exit;
    }
}
?>