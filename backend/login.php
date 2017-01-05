<?php

require_once "connect_to_db.php";


if(isset($_POST['login']) && !empty($_POST['login'] && isset($_POST['password']) && !empty($_POST['password'])))
{
    $login=mysqli_real_escape_string($DB_link,$_POST['login']);
    $password=mysqli_real_escape_string($DB_link,$_POST['password']);


    $data=mysqli_query($DB_link,"SELECT * FROM error_logs WHERE login='$login'");
    if(mysqli_num_rows($data)>3)
    {
        header('Location:'.$URL.'loginpage.php?login=4');
        exit;
    }

    $data = mysqli_query($DB_link,"select login, passw, id_user, salt from users where login='$login'");

    if(mysqli_num_rows($data)!=1)
    {
        header('Location:'.$URL.'loginpage.php?login=3'); //brak loginu lub (jakims cudem) więcej niż 1 identyczny login
        //echo mysqli_num_rows($data);
        exit;
    }
    $row=mysqli_fetch_assoc($data);


    if($row['login']==$login && $row['passw']==hash("sha256",$password.$SALT.$row['salt']))
    {
        foreach ($_SERVER as $k=>$v) {$_SERVER[$k] = mysqli_real_escape_string($DB_link, $v);}

        $id_user=$row['id_user'];

        // byc moze do usuniecia (wtedy: dorobic czyszczenie sesji w sytuacji gdy usunieto cookies albo zostawic zeby zrobil to czyszczacy event)

        //wymuszenie usuniecia ew. innych sesji uzytkownika
        mysqli_query($DB_link,"CALL pForceRemoveSession('$login');");

        $token=hash('sha256',(md5(rand(-10000,10000) . microtime()) . $_SERVER['REMOTE_ADDR']));
        $action_token=hash('sha256',rand(-90000,90000));
        mysqli_query($DB_link,"CALL pAddSession('$login','$_SERVER[REMOTE_ADDR]','$token','$_SERVER[HTTP_USER_AGENT]','$action_token');");

        setcookie('id_user', $id_user, false,'/');
        setcookie('token', $token, false,'/');
        setcookie('action_token',$action_token,false,'/');

        //echo "zalogowano poprawnie";
        header('Location:'.$URL.'mainpage.php');
        exit;
    }
    else
    {
        $ip=$_SERVER['REMOTE_ADDR'];
        mysqli_query($DB_link,"INSERT INTO error_logs(ip_address, login) VALUES('$ip','$login')");
        header('Location:'.$URL.'loginpage.php?login=1');
        exit;
    }
}
else
{
    //echo "Login i/lub hasło nie wprowadzone!";
    header('Location:'.$URL.'loginpage.php?login=2');
    exit;
}

?>
