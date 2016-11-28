<?php

require_once "connect_to_db.php";

//todo: zmienic zawartosc cookie na id usera zamiast loginu

if(isset($_POST['login']) && !empty($_POST['login'] && isset($_POST['password']) && !empty($_POST['password'])))
{
    $login=mysqli_real_escape_string($DB_link,$_POST['login']);
    $password=mysqli_real_escape_string($DB_link,$_POST['password']);

    //only for debug: //todo: usunac kiedy bedzie zbedne
    /*echo "login:".$login."<br>";
    echo "haslo:".$password."<br>";;
    echo "sha256 z hasla + soli:".hash("sha256",$password.$SALT)."<br>";*/

    $data = mysqli_query($DB_link,"select login, passw from users where login='$login'");

    if(mysqli_num_rows($data)!=1)
    {
        header("location: loginpage.php?login=3"); //brak loginu lub (jakims cudem) więcej niż 1 identyczny login
        //echo mysqli_num_rows($data);
        exit;
    }
    $row=mysqli_fetch_assoc($data);

    if($row['login']==$login && $row['passw']==hash("sha256",$password.$SALT))
    {
        foreach ($_SERVER as $k=>$v) {$_SERVER[$k] = mysqli_real_escape_string($DB_link, $v);}

        //todo: byc moze do usuniecia
        mysqli_query($DB_link,"CALL pForceRemoveSession('$login');"); //wymuszenie usuniecia ew. innych sesji uzytkownika

        $token= hash('sha256',(md5(rand(-10000,10000) . microtime()) . $_SERVER['REMOTE_ADDR']));
        //echo $login;
        mysqli_query($DB_link,"CALL pAddSession('$login','$_SERVER[REMOTE_ADDR]','$token','$_SERVER[HTTP_USER_AGENT]');");

        setcookie('login', $login, false);
        setcookie('token', $token, false);

        //echo "zalogowano poprawnie";
        header('Location: mainpage.php');
        exit;
    }
    else
    {
        //echo "Błędne hasło!"; //todo: usunac po zdebugowaniu
        header('Location: loginpage.php?login=1');
        exit;
    }
}
else
{
    //echo "Login i/lub hasło nie wprowadzone!"; //todo: usunac po zdebugowaniu
    header('Location: loginpage.php?login=2');
    exit;
}

?>
