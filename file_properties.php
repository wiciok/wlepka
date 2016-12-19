<link rel="stylesheet" type="text/css" href="innerpages.css">
<!--<link rel="stylesheet" type="text/css" href="file_properties.css">-->

<div id="div-alert">
    <div class="innertube">
        <h3>
            <?php
            if(isset($_GET['alert']) && !empty($_GET['alert']))
            {
                echo "<script>document.getElementById('div-alert').style.display='inherit'</script>";

                switch($_GET['alert'])
                {
                    case 2:
                        echo 'Błąd! Nie przesłano id pliku!';
                        break;
                    case 3:
                        echo "Błąd! Plik nie istnieje!";
                        break;
                    case 4:
                        echo "Nie masz praw do tego pliku!";
                        break;
                    case 5:
                        echo "Zmieniono dane!";
                        break;
                    case 6:
                        echo "Błąd edycji danych!";
                        break;
                    default:
                        echo "Niepoprawny kod komunikatu!";
                        break;
                }
            }
            ?>
        </h3>
    </div>
</div>
<div class="row">
    <div class="col-4-10">
        <div class="innertube">
            <h2>Właściwości pliku</h2>

            <?php
            require_once "connection_data.php";


            //inicjalizacja zmiennych
            $file_name='';
            $file_lang='';
            $file_timestmp='';
            $file_owner='';

            //sprawdzenie poprawności GETa
            if(!(isset($_GET['id_file']) && !empty($_GET['id_file'])))
            {
                //echo $_GET['id_file'];
                echo "Błąd! Nie przesłano id pliku!";
                //header("location: mainpage.php?page=file_properties&alert=2");
                exit;
            }

            $id_user=mysqli_real_escape_string($DB_link,$_COOKIE['id_user']);
            $id_file=mysqli_real_escape_string($DB_link,$_GET['id_file']);

            //sprawdzenie, czy plik istnieje i czy należy do użytkownika

            $data=mysqli_query($DB_link, "
                SELECT files.name as filename, files.id_user, files.id_lang, timestmp, users.login as login, languages.name as lang_name 
                FROM files, users, languages 
                WHERE id_file='$id_file' AND languages.id_lang=files.id_lang AND users.id_user=files.id_user");

            if(mysqli_num_rows($data)!=1)
            {
                echo "Błąd! Plik nie istnieje!";
                //header("location: mainpage.php?page=file_properties&alert=3");
                exit;
            }
            $row=mysqli_fetch_assoc($data);

            if($row['id_user']!=$id_user)          //todo: mozna dorobic takze czy uzytkownik nie ma przyznanych uprawnien do pliku (albo przerobic w bazie danych)
            {
                echo "Nie masz praw do tego pliku!";
                //header("location: mainpage.php?page=file_properties&id_file=7&alert=4");
                exit;
            }

            //wszystko jest ok:
            $file_name=$row['filename'];
            $file_lang=$row['lang_name'];
            $file_timestmp=$row['timestmp'];
            $file_owner=$row['login'];

            ?>

            <form action="file_edit.php" method="POST">
                <input type="text" name="id_file" value="<?php echo "$id_file"; ?>" style="display: none">
                <input type="text" name="id_user" value="<?php echo "$id_user"; ?>" style="display: none">
                <table>
                    <tr>
                        <th>Nazwa:</th>
                        <td>
                            <input type="text" name="file_name" placeholder="<?php echo $file_name; ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>Język:</th>
                        <td>
                            <select name="lang_name" id="select_lang">
                                <?php

                                $data=mysqli_query($DB_link,"SELECT name FROM languages;");
                                $num_rows=mysqli_num_rows($data);

                                while($num_rows>0)
                                {
                                    $row=mysqli_fetch_assoc($data);
                                    if($row['name']==$file_lang)
                                        echo '<option selected="true">'.$row['name'].'</option>';
                                    else
                                        echo '<option>'.$row['name'].'</option>';
                                    $num_rows--;
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Data dodania:</th>
                        <td><?php echo $file_timestmp; ?></td>
                    </tr>
                    <tr>
                        <th>Właściciel:</th>
                        <td><?php echo $file_owner; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                                <input type="submit" value="Edytuj">
                        </td>
                    </tr>

                </table>
            </form>

        </div>
    </div>
    <div class="col-4-10">
        <div class="innertube">
            <h2>Udostępnienia</h2>
        </div>
    </div>
    <div class="col-2-10">
        <div class="innertube">
            <h2>Udostępnij</h2>
        </div>
    </div>
</div>





