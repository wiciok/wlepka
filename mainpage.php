<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- dla IE na WP -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Wlepka - aplikacja do dzielenia się kodami źródłowymi i plikami tekstowymi</title>
    <link rel="stylesheet" type="text/css" href="main.css">
    <link rel="stylesheet" type="text/css" href="mainpage.css">

    <style>
        @import url('https://fonts.googleapis.com/css?family=Comfortaa&subset=latin,latin-ext');
        @import url('http://fonts.googleapis.com/css?family=Advent+Pro&subset=latin,latin-ext');
        @import url('https://fonts.googleapis.com/css?family=Poiret+One&subset=latin-ext');
    </style>

    <?php require_once "backend/logged_in_check.php";
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
        <div id="column-left" class="col-2-10">
            <nav>
                <ul>
                    <?php
                    require_once "./admin/admin_check.php";

                    if(admin_check($DB_link))
                    {
                        echo"
                        <li>
                            <a href='admin/admin_summary.php'>
                                <div class='div-but-menu-position' id='admin-div-but'>
                                    Admin panel
                                </div>
                            </a>
                        </li>";
                    }
                    ?>
                    <li>
                        <a href="mainpage.php?page=profile_show&id_user=<?php echo htmlspecialchars($_COOKIE['id_user']); ?>">
                            <div class="div-but-menu-position">
                                Uzytkownik:
                                <?php
                                require_once "backend/connect_to_db.php";

                                if(isset($_COOKIE['id_user']))
                                {
                                    $id_user=mysqli_real_escape_string($DB_link,$_COOKIE['id_user']);
                                    $row=mysqli_fetch_assoc(mysqli_query($DB_link,"select login from users where id_user='$id_user'"));
                                    echo htmlspecialchars($row['login']);
                                }
                                else
                                    echo "powinienes byc wylogowany";
                                ?>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="backend/logout.php">
                            <div class="div-but-menu-position" id="logout-div-but">
                                Wyloguj
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="mainpage.php?page=files_summary">
                            <div class="div-but-menu-position">
                                Wyświetl pliki
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="mainpage.php?page=fileadd">
                            <div class="div-but-menu-position">
                                Dodaj plik
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="mainpage.php?page=friends">
                            <div class="div-but-menu-position">
                                Znajomi
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="mainpage.php?page=profileedit">
                            <div class="div-but-menu-position">
                                Edytuj profil
                            </div>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <div id="column-center" class="col-8-10">
            <div class="innertube">
                <?php
                    if(isset($_GET['page']) && !empty($_GET['page']))
                    {
                        switch(htmlspecialchars_decode($_GET['page']))
                        {
                            default:
                                include_once "badpage.html";
                                break;
                            case "profile_show":
                                include_once "profile_show.php";
                                break;
                            case "fileadd":
                                include_once "fileadd.php";
                                break;
                            case "profileedit":
                                include_once "profileedit.php";
                                break;
                            case "friends":
                                include_once "friends.php";
                                break;
                            case "files_summary":
                                include_once "files_summary.php";
                                break;
                            case "file_properties":
                                include_once "file_properties.php";
                                break;
                        }
                    }
                    else
                        include_once "homepage.php";
                ?>

            </div>
        </div>
    </div>
    <div id="div-cookie-info">
        <h3>
            Strona korzysta z plików cookies w celu umożliwienia logowania.
            <br>W ciasteczkach nie są przechowywane żadne dane osobiste użytkownika.
            <br><br>
            <b style="cursor: pointer" onclick="document.getElementById('div-cookie-info').style.display='none'">Zamknij</b>
        </h3>
    </div>
    <br>
</main>

<footer>
    <?php
    require_once "my_footer.php";
    ?>
</footer>



</body>
</html>