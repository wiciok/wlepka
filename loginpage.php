<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wlepka - aplikacja do dzielenia się kodami źródłowymi i plikami tekstowymi</title>
    <link rel="stylesheet" type="text/css" href="main.css">
    <link rel="stylesheet" type="text/css" href="loginpage.css">


    <style>
        @import url('https://fonts.googleapis.com/css?family=Comfortaa&subset=latin,latin-ext');
        @import url('http://fonts.googleapis.com/css?family=Advent+Pro&subset=latin,latin-ext');
        @import url('https://fonts.googleapis.com/css?family=Poiret+One&subset=latin-ext');
    </style>

    <?php
        require_once "connect_to_db.php";
        require_once "logged_in_check.php";
    ?>
</head>

<body>

<?php require_once "my_header.php"?>

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

        <div id="column-center" class="col-3-10">
            <div class="innertube">
                <h1>Rejestracja</h1>
                <div class="disp-feedback" id="reg-feedback">
                    <h3>
                        <?php
                        if(isset($_GET['reg']) && !empty($_GET['reg']))
                        {
                            echo
                            "<script>
                                document.getElementById('reg-feedback').style.display='inherit'
                            </script>";
                            switch(htmlspecialchars($_GET['reg']))
                            {
                                case 1:
                                    echo "Rejestracja wykonana poprawnie."."<br>"."Zaloguj się.";
                                    break;
                                case 2:
                                    echo "Błąd rejestracji."."<br>"."Wybierz inny login.";
                                    break;
                                case 3:
                                    echo "Błąd rejestracji."."<br>"."Wprowadz login i haslo!";
                                    break;
                                default:
                                    echo "Błąd rejestracji.";
                                    break;
                            }
                        }
                        ?>
                    </h3>
                </div>
                <form method="post" action="registration.php" name="registrationForm">
                    Imię:<br>
                    <input type="text" name="name" class="input_text"><br>
                    Nazwisko:<br>
                    <input type="text" name="surname" class="input_text"><br>
                    Login:<br>
                    <input type="text" name="login" class="input_text"><br>
                    Hasło:<br>
                    <input type="password" name="password" class="input_text"><br>
                    <br>
                    <input type="submit" id="register-submit" value="Wyślij">
                </form>
            </div>
        </div>

        <div id="column-right" class="col-3-10">
            <div class="innertube">
                <h1>Logowanie</h1>
                <div class="disp-feedback" id="login-feedback">
                    <h3>
                        <?php
                        if(isset($_GET['login']) && !empty($_GET['login']))
                        {
                            echo
                            "<script>
                                document.getElementById('login-feedback').style.display='inherit'
                            </script>";
                            switch(htmlspecialchars($_GET['login']))
                            {
                                case 1:
                                    echo "Błąd logowania."."<br>"."Niepoprawny login i/lub hasło!";
                                    break;
                                case 2:
                                    echo "Błąd logowania."."<br>"."Login i/lub hasło nie wprowadzone!";
                                    break;
                                case 3:
                                    echo "Błąd logowania."."<br>"."Nie można jednoznacznie zidentyfikować użytkownika o wprowadzonym loginie!!";
                                    break;
                                case 4:
                                    echo "Za dużo błędnych prób logowania! Odczekaj kilka minut, po czym spróbuj ponownie.";
                                    break;
                                default:
                                    echo "Nieznany blad logowania!";
                                    break;
                            }
                        }
                        ?>
                    </h3>
                </div>
                <form method="post" action="login.php" name="loginForm">
                    Login:<br>
                    <input type="text" name="login" class="input_text"><br>
                    Hasło:<br>
                    <input type="password" name="password" class="input_text"><br>
                    <br>
                    <input type="submit" id="login-submit" value="Wyślij">
                </form>
            </div>
        </div>

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