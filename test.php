<?php
require_once "connection_data.php";

$link=mysqli_connect($database_host,$login,$password,$database_name,$port)
or die("blad polaczenia  baza danych".mysqli_connect_error());

?>

<form method="post">
    <input type="text" name="login">
    <input type="submit">
</form>

<?php
if(isset($_POST['login']))
{
    echo $login;
}

/*mysqli_query($link,"insert into users(login, password, id_country) values('testlog','testpass',1);");
if(mysqli_errno($link))
{
    echo "blad";
}*/

$data = mysqli_query($link,"select * from users");
/*$wiersz= $data->fetch_assoc();
echo $wiersz['password'];

if(mysqli_errno($link))
{
    echo "blad";
}*/

while($wiersz=mysqli_fetch_assoc($data))
{
    printf("%s (%s)\n", $wiersz["login"], $wiersz["password"]);
    echo "\n\r";
}

?>
