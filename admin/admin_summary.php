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
<header id="header">
    <div class="innertube">
        <a href="/index.php"><h1>Wlepka</h1></a>
    </div>
</header>

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
        <div class="col-4-10" id="column-center">
            <div class="innertube">
                <h2>Podsumowanie użytkowników</h2>
                <table>
                    <tr>
                        <th>id_user</th>
                        <th>login</th>
                        <th>imie</th>
                        <th>nazwisko</th>
                        <th>data ur</th>
                        <th>typ</th>
                        <th>miasto</th>
                        <th>kraj</th>
                    </tr>
                    <?php
                    $data=mysqli_query($DB_link,"select * from vUsers");

                    for($i=mysqli_num_rows($data);$i>0;$i--)
                    {
                        $row=mysqli_fetch_assoc($data);

                        echo "<tr>";
                        echo "<td>".htmlspecialchars($row['id_user'])."</td>";
                        echo "<td>".htmlspecialchars($row['login'])."</td>";
                        echo "<td>".htmlspecialchars($row['name'])."</td>";
                        echo "<td>".htmlspecialchars($row['surname'])."</td>";
                        echo "<td>".htmlspecialchars($row['birth_date'])."</td>";
                        echo "<td>".htmlspecialchars($row['user_type'])."</td>";
                        echo "<td>".htmlspecialchars($row['city'])."</td>";
                        echo "<td>".htmlspecialchars($row['country_name'])."</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
        <div class="col-4-10" id="column-right">
            <div class="innertube">
                <h2>Podsumowanie plików</h2>
                <table>
                    <tr>
                        <th>id_file</th>
                        <th>name</th>
                        <th>lang</th>
                        <th>timestamp</th>
                        <th>liczba udost</th>
                    </tr>
                    <?php
                    $data=mysqli_query($DB_link,"select * from vFiles");

                    for($i=mysqli_num_rows($data);$i>0;$i--)
                    {
                        $row=mysqli_fetch_assoc($data);

                        echo "<tr>";
                        echo "<td>".htmlspecialchars($row['id_file'])."</td>";
                        echo "<td><a href='".$URL.'backend/download_file.php?id_file='.$row['id_file']."'>".htmlspecialchars($row['name'])."</a></td>";
                        echo "<td>".htmlspecialchars($row['langname'])."</td>";
                        echo "<td>".htmlspecialchars($row['timestmp'])."</td>";
                        echo "<td>".htmlspecialchars($row['shares_num'])."</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
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
