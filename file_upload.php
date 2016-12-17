<?php

//todo: refaktoryzacja

require_once "connect_to_db.php";
require_once "file_constants.php";

$ret_code=0;

if(isset($_FILES['file']) && !empty($_FILES['file']) && isset($_POST['lang_name']) && !empty($_POST['lang_name']))
{
    $lang_name=mysqli_real_escape_string($DB_link,$_POST['lang_name']);

    $id_user=mysqli_real_escape_string($DB_link,$_COOKIE['id_user']);
    $FILE_TARGET_DIR = "uploaded_files/".$id_user."/";

    if (!file_exists($FILE_TARGET_DIR))
    {
        mkdir($FILE_TARGET_DIR, 0755, true);
    }
    $file_name=mysqli_real_escape_string($DB_link,$_FILES["file"]["name"]);
    $target_file = $FILE_TARGET_DIR . basename($file_name);
    $uploadOk = 1;

    $filename_pattern = '/^[\p{L}\p{N}_ ,\.]{1,255}$/u'; //todo:mozna to dopracowac
    if(!preg_match($filename_pattern,$file_name))
    {
        $ret_code=6;
        $uploadOk = 0;
    }


    if (file_exists($target_file))
    {
        echo "nazwa: ".$file_name;
        echo "Sorry, file already exists.";
        $uploadOk = 0;
        $ret_code=2;
    }

    if ($_FILES["file"]["size"] > $FILE_MAX_SIZE)
    {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
        $ret_code=3;
    }


    if ($uploadOk == 0)
    {
        echo "Sorry, your file was not uploaded.";
    }
    else
    {
        $data=mysqli_query($DB_link,"SELECT id_lang FROM languages WHERE name='$lang_name'");
        $row=mysqli_fetch_assoc($data);
        $lang_id=$row['id_lang'];

        mysqli_query($DB_link, "INSERT INTO files(path,name,id_user,id_lang) VALUES('$target_file','$file_name','$id_user','$lang_id')");

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file) && !mysqli_error($DB_link))
        {
            echo "The file ". $file_name. " has been uploaded.";
            $ret_code=1;
        }
        else
        {
            echo "Sorry, there was an error uploading your file.";
            $ret_code=4;
        }
    }
}
else
{
    echo "blad metody post";
    $ret_code=5;
}

header("Location: mainpage.php?page=fileadd&alert=".$ret_code);

?>