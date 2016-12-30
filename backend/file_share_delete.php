<?php
require_once "connect_to_db.php";
require_once "backend_logged_in_check.php";

$retcode=0;
try
{
    if(isset($_POST['id_user']) && !empty($_POST['id_user']) && isset($_POST['id_file']) && !empty($_POST['id_file']) && isset($_POST['id_permission']) && !empty($_POST['id_permission']))
    {
        $id_user=mysqli_real_escape_string($DB_link,$_POST['id_user']);
        $id_file=mysqli_real_escape_string($DB_link,$_POST['id_file']);
        $id_permission=mysqli_real_escape_string($DB_link,$_POST['id_permission']);


        mysqli_query($DB_link, "DELETE FROM shares WHERE id_user='$id_user' AND id_file='$id_file' AND id_permission='$id_permission'");

        if(mysqli_error($DB_link))
            throw new mysqli_sql_exception("blad usuwania udostepnienia");
}

    else
    {
        throw new Exception("bledne dane przeslane przez POST");
    }
}
catch(Exception $e)
{
    echo $e->getMessage();
    $retcode=7;
}

finally
{
    if(isset($id_file))
        header('Location:'.$URL.'mainpage.php?page=file_properties&id_file='.$id_file.'&alert='.$retcode);
    else
        header('Location:'.$URL.'mainpage.php');
    exit;
}


?>