<?php

require_once "connect_to_db.php";
require_once "backend_logged_in_check.php";

function download_file($file)
{
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    }
}

if(isset($_GET['id_file']) && !empty($_GET['id_file']))
{

    $id_file=mysqli_real_escape_string($DB_link,$_GET['id_file']);
    $id_user=mysqli_real_escape_string($DB_link,$_COOKIE['id_user']);

    //jesli user jest adminem
    $adm_d=mysqli_query($DB_link,"SELECT user_type FROM users WHERE id_user='$id_user' AND user_type='admin'");
    if(mysqli_num_rows($adm_d)==1)
    {
        $data=mysqli_query($DB_link,"SELECT id_file, path FROM files WHERE id_file='$id_file'");
        $row=mysqli_fetch_assoc($data);
        echo $row['path'];
        download_file($row['path']);
    }


    $data=mysqli_query($DB_link,"SELECT id_file, path FROM files WHERE id_file='$id_file' AND id_user='$id_user'");
    if(mysqli_num_rows($data)!=1)
    {
        $data2=mysqli_query($DB_link,"
                    SELECT id_file FROM shares, friends     /*read / read/write friends*/
                    WHERE 
                      (
                        (shares.id_user=friends.id_user_1 AND friends.id_user_2='$id_user')
                        OR (shares.id_user=friends.id_user_2 AND friends.id_user_1='$id_user')
                      ) 
                     AND friends.status='confirmed' 
                     AND (shares.id_permission=1 OR shares.id_permission=2)
                     AND shares.id_file='$id_file'
                     
                    UNION   /*read_all*/
                      SELECT id_file 
                      FROM shares 
                      WHERE id_permission=3 
                      AND id_user!='$id_user'
                      AND shares.id_file='$id_file'
                      
                    UNION   /*read / read/write user*/
                      SELECT id_file FROM shares, permissions 
                      WHERE shares.id_permission=permissions.id_permission 
                      AND shares.id_permission>3 
                      AND id_shared_user='$id_user'
                      AND shares.id_file='$id_file'
                    ");

        if(mysqli_num_rows($data2)==1)
        {
            //plik istnieje i jest dla nas udostępniony
            $data=mysqli_query($DB_link,"SELECT id_file, path FROM files WHERE id_file='$id_file'");
            $row=mysqli_fetch_assoc($data);
            echo $row['path'];
            download_file($row['path']);
        }

        else
        {
            //plik nie istnieje lub nie mamy do niego praw
            //echo "cos nie dziala";
            header('Location:'.$URL.'index.php');
            exit;
        }
    }
    else
    {
        //jesteśmny właścicielem pliku i plik istnieje
        $row=mysqli_fetch_assoc($data);
        echo $row['path'];
        download_file($row['path']);
    }
}

else
{
    echo "GET nie ustawiony!";
}



?>