<?php
require_once "admin_logged_in_check.php";
require_once "../backend/connect_to_db.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- dla IE na WP -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Wlepka - aplikacja do dzielenia się kodami źródłowymi i plikami tekstowymi</title>
    <link rel="stylesheet" type="text/css" href="../main.css">
    <link rel="stylesheet" type="text/css" href="admin.css">


    <style>
        @import url('https://fonts.googleapis.com/css?family=Comfortaa&subset=latin,latin-ext');
        @import url('http://fonts.googleapis.com/css?family=Advent+Pro&subset=latin,latin-ext');
        @import url('https://fonts.googleapis.com/css?family=Poiret+One&subset=latin-ext');
    </style>
</head>

<body>
<?php
require_once "../my_header.html"
?>

<main>
    <div class="row" id="main-row">
        <div id="column-left" class="col-2-10">
            <div class="innertube">
                <h2>
                    Wlepka
                    <br>
                    Panel administracyjny
                </h2>
            </div>
        </div>
        <div class="col-8-10" id="column-right">
            <div class="innertube">
                <h2>Podsumowanie plików i ich właścicieli</h2>

            </div>
        </div>
</main>

<footer>
    <div id="footer">
        <div class="innertube">
            <p>Witold Karaś 2016</p>
        </div>
    </div>
</footer>

</body>
</html>