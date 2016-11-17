<?php
require_once "connection_data.php";

$link=mysqli_connect($DB_database_host,$DB_login,$DB_password,$DB_database_name,$DB_port)
or die("blad polaczenia  baza danych".mysqli_connect_error());

?>

<form method="post">
    <input type="text" name="login">
    <input type="submit">
</form>

<?php
if(isset($_POST['login']))
{
    echo $DB_login;
}

//echo getenv('DB_PASS_HASH');
echo sha1(getenv('DB_PASS_HASH')."fjkghnuire9ph4389ut-8gqrehjg3nbrqit435=8th1qg"."password");

/*mysqli_query($link,"insert into users(login, password, id_country) values('testlog','testpass',1);");
if(mysqli_errno($link))
{
    echo "blad";
}*/

/*$data = mysqli_query($link,"select * from users");
/*$wiersz= $data->fetch_assoc();
echo $wiersz['password'];

if(mysqli_errno($link))
{
    echo "blad";
}*/
/*
while($wiersz=mysqli_fetch_assoc($data))
{
    printf("%s (%s)\n", $wiersz["login"], $wiersz["password"]);
    echo "\n\r";
}*/

?>
