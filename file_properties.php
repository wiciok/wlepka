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
                            <input type="submit" name="edit" value="Edytuj">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" name="delete" value="Usuń plik">
                            <!-- todo: ZROBIĆ USUWANIE PLIKU! -->
                        </td>
                    </tr>

                </table>
            </form>

        </div>
    </div>
    <div class="col-3-10">
        <div class="innertube">
            <h2>Udostępnienia</h2>
            <table>
                <tr>
                    <th>Typ:</th>
                    <th>Użytkownik:</th>
                </tr>
                <?php

                require_once "connect_to_db.php";

                $dict=[
                    "read_friends"=>"Odczyt - wszyscy znajomi",
                    "read_write_friends"=>"Odczyt/zapis - wszyscy znajomi",
                    "read_user"=>"Odczyt - znajomy",
                    "read_write_user"=>"Odczyt/zapis - znajomy",
                    "read_all"=>"Odczyt - wszyscy"
                ];

                $data=mysqli_query($DB_link, "
                          SELECT shares.id_permission, permission_name, login 
                          FROM permissions LEFT JOIN users ON permissions.id_shared_user=users.id_user 
                          LEFT JOIN shares ON shares.id_permission=permissions.id_permission 
                          WHERE id_file='$id_file'");

                if(mysqli_num_rows($data)>0)
                {
                    for($i=mysqli_num_rows($data);$i>0;$i--)
                    {
                        $row=mysqli_fetch_assoc($data);
                        $id_permission=$row['id_permission'];

                        echo "<tr>";
                        //echo "<td>".$row['permission_name']."</td>";
                        echo "<td>".$dict[($row['permission_name'])]."</td>";
                        echo "<td>".$row['login']."</td>";
                        echo "</tr><tr>";
                        echo "<td colspan='2'>"."
                        <form action='file_share_delete.php' method='post'>
                        <input type='text' name='id_user' style='display:none' value='$id_user'>
                        <input type='text' name='id_file' style='display: none' value='$id_file'>
                        <input type='text' name='id_permission' style='display:none' value='$id_permission'>
                        <input type='submit' value='Usuń'>
                        </form></td>";
                        echo "</tr>";
                    }
                }
                else
                    echo "<tr></tr><td colspan='2'>"."brak udostępnień!"."</td></tr>";
                ?>

            </table>

        </div>
    </div>

    <div class="col-3-10">
        <div class="invisible-container">
            <datalist id="friends_logins_list">
                <?php
                require_once "connect_to_db.php";


                $id_user=mysqli_real_escape_string($DB_link,$_COOKIE['id_user']);

                //wyswietlamy tylko loginy userów, których mamy ich w znajomych i są potwierdzeni
                $data=mysqli_query($DB_link,"
                    SELECT login FROM users 
                    WHERE id_user!=$id_user
                    AND id_user= ANY(SELECT id_user_1 FROM friends WHERE id_user_2=$id_user AND status='confirmed')
                    OR id_user=ANY(SELECT id_user_2 FROM friends WHERE id_user_1=$id_user AND status='confirmed');
                     ");
                $num_rows=mysqli_num_rows($data);

                while($num_rows>0)
                {
                    $row=mysqli_fetch_assoc($data);
                    echo "<option value='".$row['login']."'>".$row['login']."</option>";
                    $num_rows--;
                }
                ?>
            </datalist>
        </div>
        <div class="innertube">
            <h2>Udostępnij</h2>

            <script>
                function show_login_list()
                {
                    if(document.getElementById('permission_type').value=='read_user' || document.getElementById('permission_type').value=='read_write_user')
                        document.getElementById("login_list").style.display='inherit';
                }
            </script>

            <form method="post" id="share_form" action="file_share_add.php">
                <select name="permission_type" id="permission_type" onchange="show_login_list()">
                    <option value="read_friends"><?php echo $dict['read_friends'] ?></option>
                    <option value="read_write_friends"><?php echo $dict['read_write_friends'] ?></option>
                    <option value="read_user"><?php echo $dict['read_user'] ?></option>
                    <option value="read_write_user"><?php echo $dict['read_write_user'] ?></option>
                    <option value="read_all"><?php echo $dict['read_all'] ?></option>
                </select>
                <br>
                <input list="friends_logins_list" id="login_list" name="login" placeholder="wpisz login" value="" style="display: none">

                <input name="id_file" value="<?php echo $id_file ?>" style="display: none">
                <input name="id_user" value="<?php echo $id_user ?>" style="display: none">
                <br>
                <br>
                <input id="submit-add-friend" type="submit" value="Udostępnij">
            </form>
        </div>
    </div>
</div>





