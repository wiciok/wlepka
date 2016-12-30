<?php
require_once "connect_to_db.php";
require_once "backend_logged_in_check.php";

//todo: usuwanie cudzego pliku
if(!(isset($_POST['id_file']) && !empty($_POST['id_file']) && isset($_POST['id_user']) && !empty($_POST['id_user'])))
{
    echo "Blad! Nie przeslano id_file lub id_user!";
    exit;
}

$id_file=mysqli_real_escape_string($DB_link,$_POST['id_file']);
$id_user=mysqli_real_escape_string($DB_link,$_POST['id_user']);

//usuwanie pliku
if($_POST['delete'])
{
    try
    {
        mysqli_query($DB_link,"SET autocommit=0;");
        mysqli_query($DB_link,"SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
        mysqli_query($DB_link,"START TRANSACTION READ WRITE");


        $data=mysqli_query($DB_link,"SELECT path FROM files WHERE id_file='$id_file'");
        if(mysqli_num_rows($data)!=1)
            throw new mysqli_sql_exception("ilosc plikow o danym id rozna od 1");
        $row=mysqli_fetch_assoc($data);
        $path=$row["path"];


        //wczytanie pozostałych udostępnień
        $data=mysqli_query($DB_link,"
          SELECT id_permission 
          FROM shares 
          WHERE id_file='$id_file'
          AND NOT(id_permission=1 OR id_permission=2 OR id_permission=3)");

        if(!unlink($path))
            throw new Exception("blad fizycznego usuwania pliku");

        mysqli_query($DB_link,"DELETE FROM files WHERE id_file='$id_file'");
        if(mysqli_error($DB_link) || mysqli_affected_rows($DB_link)!=1)
            throw new mysqli_sql_exception("blad usuwania pliku z bazy");

        //usuniecie pozostalych udostepnien

        for ($i=mysqli_num_rows($data);$i>0;$i--)
        {
            $row=mysqli_fetch_assoc($data);
            $id_permission=$row['id_permission'];
            mysqli_query($DB_link,"DELETE FROM permissions WHERE id_permission='$id_permission'");
        }

        if($e=mysqli_error($DB_link))
            throw new mysqli_sql_exception("blad usuwania zbednych uprawnien z bazy".$e);

        mysqli_query($DB_link,"COMMIT");
    }

    catch(Exception $e)
    {
        echo $e->getMessage();
        $retcode=1;
        mysqli_query($DB_link,"ROLLBACK");
    }

    finally
    {
        mysqli_query($DB_link,"SET autocommit=1;");
        header('Location:'.$URL.'mainpage.php?page=files_summary&alert='.$retcode);
        exit;
    }
}

//zmiana nazwy
try
{
    mysqli_query($DB_link,"SET autocommit=0;");
    mysqli_query($DB_link,"SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
    //mysqli_query($DB_link,"START TRANSACTION READ WRITE");
    if(!mysqli_begin_transaction($DB_link))
        throw new Exception("transakcja nie wystartowała!");

    if(isset($_POST['file_name']) && !empty($_POST['file_name']))
    {
        $new_file_name=mysqli_real_escape_string($DB_link,$_POST['file_name']);

        $data=mysqli_query($DB_link,"SELECT name, id_user FROM files WHERE id_file='$id_file'");
        if(mysqli_num_rows($data)!=1)
            throw new mysqli_sql_exception("Plik o danym id nie istnieje!");

        $row=mysqli_fetch_assoc($data);
        $old_file_name=$row['name'];
        $owner=$row['id_user'];

        if(!(rename("../uploaded_files/".$owner."/".$old_file_name,"../uploaded_files/".$owner."/".$new_file_name)))
            throw new Exception("Blad podczas fizycznej zmiany nazwy pliku");

        mysqli_query($DB_link,"UPDATE files SET name='$new_file_name' WHERE id_file='$id_file'");
        $new_path="uploaded_files/".$owner."/".$new_file_name;
        mysqli_query($DB_link,"UPDATE files SET path='$new_path' WHERE id_file='$id_file'");
    }

//zmiana języka
    if(isset($_POST['lang_name']) && !empty($_POST['lang_name']))
    {
        $lang_name=mysqli_real_escape_string($DB_link,$_POST['lang_name']);

        $data=mysqli_query($DB_link,"SELECT id_lang FROM languages WHERE name='$lang_name'");
        if(mysqli_num_rows($data)!=1)
            throw new Exception("Język o danej nazwie nie istnieje!");

        $row=mysqli_fetch_assoc($data);
        $id_lang=$row['id_lang'];
        mysqli_query($DB_link,"UPDATE files SET id_lang='$id_lang'");
    }

    if($e=mysqli_error($DB_link))
       throw new mysqli_sql_exception("Blad mysqli! ".$e);

    $retcode=5;

    sleep(30);
    mysqli_query($DB_link,"COMMIT");
}

catch(Exception $e)
{
    $retcode=6;
    echo $e->getMessage();
    mysqli_query($DB_link,"ROLLBACK");
}

finally
{
    mysqli_query($DB_link,"SET autocommit=1;");
    header('Location:'.$URL.'mainpage.php?page=file_properties&id_file='.$_POST["id_file"].'&alert='.$retcode);
    exit;
}
?>