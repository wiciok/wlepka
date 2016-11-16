<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wlepka - aplikacja do dzielenia się kodami źródłowymi i plikami tekstowymi</title>
    <link rel="stylesheet" type="text/css" href="main.css">
    <link rel="stylesheet" type="text/css" href="mainpage.css">

    <style>
        @import url('https://fonts.googleapis.com/css?family=Comfortaa&subset=latin,latin-ext');
        @import url('http://fonts.googleapis.com/css?family=Advent+Pro&subset=latin,latin-ext');
        @import url('https://fonts.googleapis.com/css?family=Poiret+One&subset=latin-ext');
    </style>

    <?php require_once "logged_in_check.php"; ?>
</head>

<body>


<header id="header">
    <div class="innertube">
        <h1>Wlepka</h1>
    </div>
</header>

<div id="JSValidator">
    <h2>
        JavaScript jest wyłączony!<br>
        Włącz JS aby umożliwić poprawne działanie witryny!
    </h2>
    <script>
        document.getElementById("JSValidator").style.display="none"
    </script>
</div>

<main>
    <div class="row" id="main-row">
        <div id="column-left" class="col-2-10">
            <nav>
                <ul>
                    <li> <!-- todo: dorobic wylogowywanie-->
                        <a href="logout.php">
                            <div class="div-but-menu-position" id="logout-div-but">
                                Uzytkownik:<?php echo $_COOKIE['login']; ?>
                                <br>
                                Wyloguj
                            </div>
                        </a>
                    </li>
                    <li>
                        <a>
                            <div class="div-but-menu-position">
                                Twoje pliki
                            </div>
                        </a>
                    </li>
                    <li>
                        <a>
                            <div class="div-but-menu-position">
                                Dodaj plik
                            </div>
                        </a>
                    </li>
                    <li>
                        <a>
                            <div class="div-but-menu-position">
                                Udostepnione pliki
                            </div>
                        </a>
                    </li>
                    <li>
                        <a>
                            <div class="div-but-menu-position">
                                Znajomi
                            </div>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <div id="column-center" class="col-8-10">
            <div class="innertube">
                <h1>kątęnt</h1>
            </div>
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