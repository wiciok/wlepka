<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wlepka - aplikacja do dzielenia się kodami źródłowymi i plikami tekstowymi</title>
    <link rel="stylesheet" type="text/css" href="mainpage.css">

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

<main>
    <div class="row" id="main-row">
        <div id="column-left" class="col-2-10">
            <nav>
                <ul>
                    <li>
                        <button class="but-menu-position" id="logout-button">
                            Uzytkownik: <!-- todo: tu bedzie kod php zwracajacy login -->
                            <br>
                            Wyloguj
                        </button>

                    </li>
                    <li>
                        <button class="but-menu-position">
                            menu1
                        </button>
                    </li>
                    <li>
                        <button class="but-menu-position">
                            menu2
                        </button>
                    </li>
                    <li>
                        <button class="but-menu-position">
                            menu3
                        </button>
                    </li>
                </ul>
            </nav>
        </div>

        <div id="column-center" class="col-6-10">
            <div class="innertube">

            </div>
        </div>

        <div id="column-right" class="col-2-10">
            <div class="innertube">

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