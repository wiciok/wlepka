<?php
//todo: jeśli wprowadze mozliwosc edytowania plikow przez udostepnione osoby, to dorobić tutaj transakcje
require_once "connect_to_db.php";


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
    //todo: dorobić usuwanie pliku!!!!
}

//zmiana nazwy
try
{
    if(isset($_POST['file_name']) && !empty($_POST['file_name']))
    {
        $new_file_name=mysqli_real_escape_string($DB_link,$_POST['file_name']);

        $data=mysqli_query($DB_link,"SELECT name FROM files WHERE id_file='$id_file'");
        if(mysqli_num_rows($data)!=1)
            throw new mysqli_sql_exception("Plik o danym id nie istnieje!");

        $row=mysqli_fetch_assoc($data);
        $old_file_name=$row['name'];

        if(!(rename("uploaded_files/".$id_user."/".$old_file_name,"uploaded_files/".$id_user."/".$new_file_name)))
            throw new Exception("Blad podczas fizycznej zmiany nazwy pliku");

        mysqli_query($DB_link,"UPDATE files SET name='$new_file_name' WHERE id_file='$id_file'");
        $new_path="uploaded_files/".$id_user."/".$new_file_name;
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

    if(mysqli_errno($DB_link))
       throw new mysqli_sql_exception("Blad mysqli! ");
}

catch(Exception $e)
{
    echo $e;
    header("location: mainpage.php?page=file_properties&id_file=".$_POST['id_file']."&alert=6");
    exit;
}

finally
{
    header("location: mainpage.php?page=file_properties&id_file=".$_POST['id_file']."&alert=5");
    exit;
}

?>