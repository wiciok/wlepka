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

    <?php
        require_once "backend/connect_to_db.php";
        require_once "backend/logged_in_check.php";
    ?>
</head>

<body>

<?php require_once "my_header.html" ?>

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
                                case 4:
                                    echo "Błąd rejestracji! Niedozwolony format loginu!"."<br>"."Dozwolone tylko litery i cyfry, spacja znak podkreślenia!";
                                    break;
                                case 5:
                                    echo "Błąd rejestracji! Niedozwolone znaki!"."<br>"."Dozwolone tylko litery!";
                                    break;
                                default:
                                    echo "Błąd rejestracji.";
                                    break;
                            }
                        }
                        ?>
                    </h3>
                </div>
                <script src="registration_check_ajax.js"></script>
                <form method="post" action="backend/registration.php" name="registrationForm">
                    Imię:<br>
                    <input type="text" name="name" class="input_text"><br>
                    Nazwisko:<br>
                    <input type="text" name="surname" class="input_text"><br>
                    Login:<br>
                    <input type="text" name="login" id="input-login" class="input_text" onblur="checkInDatabase('login',this.value)"><br>
                    Hasło:<br>
                    <input type="password" name="password" id="input-password" class="input_text" onblur="checkInDatabase('password',this.value)"><br>
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
                <form method="post" action="backend/login.php" name="loginForm">
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
    <?php
    require_once "my_footer.php";
    ?>
</footer>



</body>
</html>