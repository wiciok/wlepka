<?php

require_once "connection_data.php";

$DB_link=mysqli_connect($DB_database_host,$DB_login,$DB_password,$DB_database_name,$DB_port)
or die("blad polaczenia z baza danych".mysqli_connect_error());

?>