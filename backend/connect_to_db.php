<?php header('Content-Type: text/html; charset=utf-8'); ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
require_once "connection_data.php";

$DB_link=mysqli_connect($DB_database_host,$DB_login,$DB_password,$DB_database_name,$DB_port)
or die("blad polaczenia z baza danych".mysqli_connect_error().mysqli_connect_errno());

//ustawienie kodowania
mysqli_query($DB_link,("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'"));

?>