<?php

require_once "../backend/connect_to_db.php";

header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0, max-age=0", false);
header("Pragma: no-cache");

if (isset($_COOKIE['id_user']) && isset($_COOKIE['token']) && isset($_COOKIE['action_token']))
{
    $cookieID_user=mysqli_real_escape_string($DB_link,trim($_COOKIE['id_user'],"'"));
    $cookieToken=mysqli_real_escape_string($DB_link,trim($_COOKIE['token'],"'"));

    $data = mysqli_query($DB_link,"select current_sessions.id_user, current_sessions.token from current_sessions where current_sessions.id_user='$cookieID_user' and current_sessions.token='$cookieToken'");

    if(mysqli_num_rows($data)!=1)
    {
        header("location: ".$URL."backend/logout.php");
    }
    else //dane sie zgadzają
    {
        //sprawdzenie action_tokena - zabezpieczenie przed przechwyceniem ciasteczka

        $action_token=mysqli_real_escape_string($DB_link,$_COOKIE['action_token']);
        $data=mysqli_query($DB_link,"SELECT action_token FROM current_sessions WHERE id_user='$cookieID_user'");
        $row=mysqli_fetch_assoc($data);

        if($action_token==$row['action_token'])
        {
            $action_token=hash('sha256',rand(-90000,90000));
            mysqli_query($DB_link,"UPDATE current_sessions SET action_token='$action_token' WHERE id_user='$cookieID_user'");
            setcookie('action_token',$action_token,false,'/');
            //echo "poprawne zalogowanie";

            //sprawdzenie czy zalogowany user jest adminem
            require_once "admin_check.php";

            if(!admin_check($DB_link))
            {
                header('Location:'.$URL.'mainpage.php');
                exit;
            }

            else
            {
                if (basename($_SERVER['PHP_SELF'])!="admin_summary.php")
                {
                    header('Location:'.$URL.'admin/admin_summary.php');
                    exit;
                }
            }
        }
        else
        {
            //echo "przechwycona sesja";
            header('Location: '.$URL.'/backend/logout.php');
            exit;
        }
    }
}
else
{
    if (basename($_SERVER['PHP_SELF'])!="loginpage.php")
    {
        //echo "brak cookie";
        header('Location:'.$URL.'loginpage.php');
        exit;
    }
}
?>