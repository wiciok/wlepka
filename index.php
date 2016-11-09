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
</head>

<body>


<header id="header">
    <div class="innertube">
        <h1>Wlepka</h1>
    </div>
</header>

<div id="JSValidator"> <!--todo: skrypt javascript ustawiajacy display:none -->
    <h2>
        JavaScript jest wyłączony!<br>
        Włącz JS aby umożliwić poprawne działanie witryny!
    </h2>
</div>

<main>
    <div class="row" id="main-row">
        <div id="column-left" class="col-4-10">
            <div class="innertube">
                <h2>Wlepka - aplikacja do dzielenia się kodami źródłowymi i plikami tekstowymi</h2>
            </div>
        </div>

        <div id="column-center" class="col-3-10">
            <div class="innertube">
                <h1>Rejestracja</h1>
                <form method="post">
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
                <form method="post">
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
            <p>Witold Karaś 2016</p>
        </div>
    </div>
</footer>



</body>
</html>