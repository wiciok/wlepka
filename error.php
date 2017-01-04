<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- dla IE na WP -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Wlepka - aplikacja do dzielenia się kodami źródłowymi i plikami tekstowymi</title>
    <link rel="stylesheet" type="text/css" href="main.css">
    <link rel="stylesheet" type="text/css" href="loginpage.css">


    <style>
        @import url('https://fonts.googleapis.com/css?family=Comfortaa&subset=latin,latin-ext');
        @import url('http://fonts.googleapis.com/css?family=Advent+Pro&subset=latin,latin-ext');
        @import url('https://fonts.googleapis.com/css?family=Poiret+One&subset=latin-ext');
    </style>
</head>

<body>
<?php
require_once "my_header.html";
?>

<main>
    <div class="row" id="main-row">
        <div id="column-left" class="col-4-10">
            <div class="innertube">
                <h2>Wlepka - aplikacja do dzielenia się kodami źródłowymi i plikami tekstowymi</h2>
                <br>
                <div id="div-cookie-info">
                    <h3>
                        Strona korzysta z plików cookies w celu umożliwienia logowania.
                        <br>W ciasteczkach nie są przechowywane żadne dane osobiste użytkownika.
                        <br><br>
                        <b style="cursor: pointer" onclick="document.getElementById('div-cookie-info').style.display='none'">Zamknij</b>
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-6-10">
            <h1 style="text-align: center; font-size: 4em;"><br>Wystąpił błąd
                <?php

                if(isset($_GET['id']) && !empty($_GET['id']))
                    echo $_GET['id'];
                ?>
                !</h1>
            <h3 style="text-align: center">Wróć na stronę główną klikając na górną belkę.</h3>
        </div>
</main>

<footer>
    <div id="footer">
        <div class="innertube">
            <p>Witold Karaś 2016<br>
                <span style="cursor: pointer" onclick="document.getElementById('div-cookie-info').style.display='inherit'">Informacje o cookies</span>
            </p>
        </div>
    </div>
</footer>



</body>
</html>