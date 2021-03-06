<?php

require_once "connect_to_db.php";
require_once "file_constants.php";
require_once "backend_logged_in_check.php";

$ret_code=0;

if(isset($_FILES['file']) && !empty($_FILES['file']) && isset($_POST['lang_name']) && !empty($_POST['lang_name']))
{
    $lang_name=mysqli_real_escape_string($DB_link,$_POST['lang_name']);

    $id_user=mysqli_real_escape_string($DB_link,$_COOKIE['id_user']);
    $FILE_TARGET_DIR = "../uploaded_files/".$id_user."/";

    if (!file_exists($FILE_TARGET_DIR))
    {
        mkdir($FILE_TARGET_DIR, 0755, true);
    }
    $file_name=mysqli_real_escape_string($DB_link,$_FILES["file"]["name"]);
    $target_file = $FILE_TARGET_DIR . basename($file_name);
    $uploadOk = 1;

    $filename_pattern = '/^[\p{L}\p{N}_ ,\.]{1,255}$/u';
    if(!preg_match($filename_pattern,$file_name))
    {
        $ret_code=6;
        $uploadOk = 0;
    }


    if (file_exists($target_file))
    {
        $uploadOk = 0;
        $ret_code=2;
    }

    //z niewiadomych powodów nie działa poprawnie dla pliku exe (wywala się za to move_uploaded_file poniżej
    if ($_FILES['file']['size'] > $FILE_MAX_SIZE)
    {
        $uploadOk = 0;
        $ret_code=3;
    }

    if($uploadOk==1)
    {
        //sprawdzenie rzeczywistego typu pliku
        global $accepted_mime_content_types;
        $uploadOk=0;
        $ret_code=7;
        foreach($accepted_mime_content_types as $element)
        {
            //echo $element."<br>";
            //echo mime_content_type($_FILES["file"]["tmp_name"]);
            if(mime_content_type($_FILES["file"]["tmp_name"])==$element)
            {
                $uploadOk=1;
                $ret_code=1;
            }
        }
    }

    if ($uploadOk == 1)
    {
        $data=mysqli_query($DB_link,"SELECT id_lang FROM languages WHERE name='$lang_name'");
        $row=mysqli_fetch_assoc($data);
        $lang_id=$row['id_lang'];


        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file))
        {
            mysqli_query($DB_link, "INSERT INTO files(path,name,id_user,id_lang) VALUES('$target_file','$file_name','$id_user','$lang_id')");
            if(!mysqli_error($DB_link))
            {
                echo "ok";
                $ret_code=1;
            }
            else
                $ret_code=4;
        }
        else
            $ret_code=4;
    }
    else
        echo "plik nie zostal przeslany";
    //echo mime_content_type($target_file);
}
else
{
    echo "blad metody post";
    $ret_code=5;
}

header('Location:'.$URL.'mainpage.php?page=fileadd&alert='.$ret_code);

?>