<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- dla IE na WP -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Wlepka - aplikacja do dzielenia się kodami źródłowymi i plikami tekstowymi</title>

    <link rel="stylesheet" type="text/css" href="main.css">
    <link rel="stylesheet" type="text/css" href="mainpage.css">
    <link rel="stylesheet" type="text/css" href="innerpages.css">
    <link rel="stylesheet" type="text/css" href="file_view.css">


    <style>
        @import url('https://fonts.googleapis.com/css?family=Comfortaa&subset=latin,latin-ext');
        @import url('http://fonts.googleapis.com/css?family=Advent+Pro&subset=latin,latin-ext');
        @import url('https://fonts.googleapis.com/css?family=Poiret+One&subset=latin-ext');
    </style>
</head>

<body>
<?php require_once "my_header.html" ?>

<main>
    <div class="innertube">
        <br>
        <div style="display: inline-flex;text-align: center; width: 100%; height: 3em;">
            <button onclick="window.history.back();"><- Wróć</button>
            <div style="width: 50%">
                <h2 id="filename_h2"></h2>
            </div>
            <button id="download-button">Pobierz</button>
        </div>
    </div>

    <div class="col-10-10" id="column-center">
        <link rel="stylesheet" href="styles/default.css">
        <script src="highlight.pack.js"></script>
            <?php
            require_once "backend/connect_to_db.php";
            function show_file($file, $name)
            {
                echo "<script>document.getElementById('filename_h2').innerHTML='$name'</script>";

                $file=substr($file,3);
                $handle = fopen($file, "r");
                if ($handle)
                {
                    $line_num=1;
                    echo "<pre><code>";
                    while (($line = fgets($handle)) !== false)
                    {
                        echo $line_num.".   ";
                        $line_num++;
                        echo htmlentities($line);
                    }
                    fclose($handle);
                    echo "</code></pre>";
                }

                else {
                    // error opening the file.
                }
            }

            if(isset($_GET['id_file']) && !empty($_GET['id_file']))
            {

                $id_file=mysqli_real_escape_string($DB_link,$_GET['id_file']);
                $id_user=mysqli_real_escape_string($DB_link,$_COOKIE['id_user']);

                echo "<script>document.getElementById('download-button').onclick=
                    function() {
                        location.href='backend/download_file.php?id_file=$id_file'
                    }</script>";

                //jesli user jest adminem
                $adm_d=mysqli_query($DB_link,"SELECT user_type FROM users WHERE id_user='$id_user' AND user_type='admin'");
                if(mysqli_num_rows($adm_d)==1)
                {
                    $data=mysqli_query($DB_link,"SELECT id_file, path, name FROM files WHERE id_file='$id_file'");
                    $row=mysqli_fetch_assoc($data);
                    //echo $row['path'];
                    show_file($row['path'],$row['name']);
                }

                //user nie jest adminem
                else
                {
                    $data=mysqli_query($DB_link,"SELECT id_file, path, name FROM files WHERE id_file='$id_file' AND id_user='$id_user'");
                    if(mysqli_num_rows($data)!=1)
                    {
                        $data2=mysqli_query($DB_link,"
                        SELECT id_file FROM shares, friends     /*read / read/write friends*/
                        WHERE 
                          (
                            (shares.id_user=friends.id_user_1 AND friends.id_user_2='$id_user')
                            OR (shares.id_user=friends.id_user_2 AND friends.id_user_1='$id_user')
                          ) 
                         AND friends.status='confirmed' 
                         AND (shares.id_permission=1 OR shares.id_permission=2)
                         AND shares.id_file='$id_file'
                         
                        UNION   /*read_all*/
                          SELECT id_file 
                          FROM shares 
                          WHERE id_permission=3 
                          AND id_user!='$id_user'
                          AND shares.id_file='$id_file'
                          
                        UNION   /*read / read/write user*/
                          SELECT id_file FROM shares, permissions 
                          WHERE shares.id_permission=permissions.id_permission 
                          AND shares.id_permission>3 
                          AND id_shared_user='$id_user'
                          AND shares.id_file='$id_file'
                        ");

                        if(mysqli_num_rows($data2)==1)
                        {
                            //plik istnieje i jest dla nas udostępniony
                            $data=mysqli_query($DB_link,"SELECT id_file, path, name FROM files WHERE id_file='$id_file'");
                            $row=mysqli_fetch_assoc($data);
                            //echo $row['path'];
                            show_file($row['path'],$row['name']);
                        }

                        else
                        {
                            //plik nie istnieje lub nie mamy do niego praw
                            //echo "cos nie dziala";
                            header('Location:'.$URL.'index.php');
                            exit;
                        }
                    }
                    else
                    {
                        //jesteśmny właścicielem pliku i plik istnieje
                        $row=mysqli_fetch_assoc($data);
                        //echo $row['path'];
                        show_file($row['path'],$row['name']);
                    }
                }
            }
            else
                echo "Błąd! Nie ustawione id pliku do wyświetlenia!";
            ?>
        <script>hljs.initHighlightingOnLoad();</script>
    </div>

    <div id="div-cookie-info">
        <h3>
            Strona korzysta z plików cookies w celu umożliwienia logowania.
            <br>W ciasteczkach nie są przechowywane żadne dane osobiste użytkownika.
            <br>
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
