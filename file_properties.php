<link rel="stylesheet" type="text/css" href="innerpages.css">
<link rel="stylesheet" type="text/css" href="file_properties.css">

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
                    case 7:
                        echo "Błąd usuwania udostępnienia!";
                        break;
                    case 8:
                        echo "Błąd dodawania udostępnienia!";
                        break;
                    case 9:
                        echo "Błąd dodawania nowej wersji pliku!";
                        break;
                    case 10:
                        echo "Błąd podczas próby przesyłania pliku!"."<br>"."Plik ma zbyt duży rozmiar!";
                        break;
                    case 11:
                        echo "Błąd podczas próby przesyłania pliku!"."<br>"."Plik nie jest plikiem tekstowym!";
                        break;
                    case 13:
                        echo "Poprawnie przesłano nową wersję pliku!";
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
    <div class="col-4-10" id="col-left">
        <div class="innertube">
            <h2>Właściwości pliku</h2>

            <?php
            require_once "backend/connection_data.php";


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

            if($row['id_user']!=$id_user)
            {
                //sprawdzanie, czy plik został nam udostępniony
                $data3=mysqli_query($DB_link,"
                            SELECT permission_name, id_shared_user 
                            FROM permissions, shares
                            WHERE shares.id_permission=permissions.id_permission
                            AND shares.id_file='$id_file';
                            ");

                $flag=0;
                for($j=mysqli_num_rows($data3);$j>0;$j--)
                {
                    $row2=mysqli_fetch_assoc($data3);
                    if($row2['permission_name']==='read_write_friends')
                    {
                        //sprawdzanie czy jesteśmy znajomymi właściciela pliku
                        $data4=mysqli_query($DB_link,"
                        SELECT id_file FROM shares, friends     /* read/write friends */
                        WHERE
                        (
                            (shares.id_user=friends.id_user_1 AND friends.id_user_2='$id_user')
                            OR (shares.id_user=friends.id_user_2 AND friends.id_user_1='$id_user')
                        )
                        AND friends.status='confirmed'
                        AND shares.id_permission=2
                        AND shares.id_file='$id_file'");

                        if(mysqli_num_rows($data4)==1)
                            $flag=1;
                    }

                    if($row2['permission_name']==='read_write_user' && $row2['id_shared_user']===$id_user)
                        $flag=1;
                }

                if($flag!=1)
                {
                    //jesli user nie jest adminem
                    $adm_d=mysqli_query($DB_link,"SELECT user_type FROM users WHERE id_user='$id_user' AND user_type='admin'");
                    if(mysqli_num_rows($adm_d)!=1)
                    {
                        echo "Nie masz praw do tego pliku!";
                        //header("location: mainpage.php?page=file_properties&id_file=7&alert=4");
                        exit;
                    }
                }
            }

            //wszystko jest ok:
            $file_name=$row['filename'];
            $file_lang=$row['lang_name'];
            $file_timestmp=$row['timestmp'];
            $file_owner=$row['login'];
            ?>

            <form action="backend/file_edit.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="id_file" value="<?php echo $id_file; ?>" style="display: none">
                <input type="text" name="id_user" value="<?php echo $id_user; ?>" style="display: none">
                <table>
                    <tr>
                        <th>Nazwa:</th>
                        <td>
                            <input type="text" name="file_name" placeholder="<?php echo htmlspecialchars($file_name); ?>">
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
                                        echo '<option selected="selected">'.htmlspecialchars($row['name']).'</option>';
                                    else
                                        echo '<option>'.htmlspecialchars($row['name']).'</option>';
                                    $num_rows--;
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Data dodania:</th>
                        <td><?php echo htmlspecialchars($file_timestmp); ?></td>
                    </tr>
                    <tr>
                        <th>Właściciel:</th>
                        <td><?php echo htmlspecialchars($file_owner); ?></td>
                    </tr>
                    <tr><td><br></td></tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" name="edit" value="Zmień dane">
                        </td>
                    </tr>
                    <tr style="display: none">
                        <td colspan="2"> <!-- wywoływane przez inne elementy -->
                            <input type="file" name="file" id="file_checker">
                            <input type="submit" name="new-file" id="new-file-submit" value="Prześlij nową wersję pliku">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" name="delete" value="Usuń plik">
                        </td>
                    </tr>

                </table>
            </form>

        </div>
    </div>
    <div class="col-3-10" id="col-center-left">
        <div class="innertube">
            <h2>Edytuj plik</h2>
            <button onclick="document.getElementById('file_checker').value='';document.getElementById('file_checker').click()">Wybierz plik</button>
            <br><br>
            <button onclick="document.getElementById('new-file-submit').click()">Wyślij</button>

        </div>
    </div>
    <div class="col-3-10" id="col-center-right">
        <div class="innertube">
            <h2>Udostępnienia</h2>
            <table id="shares_table">
                <tr>
                    <th width="70%"><h3>Typ:</h3></th>
                    <th width="30%"><h3>Użytkownik:</h3></th>
                </tr>
                <?php

                require_once "backend/connect_to_db.php";

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
                        echo "<td class='data'>".$dict[($row['permission_name'])]."</td>";
                        echo "<td class='data'>".htmlspecialchars($row['login'])."</td>";
                        echo "</tr><tr>";
                        echo "<td colspan='2'>"."
                        <form action='/backend/file_share_delete.php' method='post'>
                        <input type='text' name='id_user' style='display:none' value='$id_user'>
                        <input type='text' name='id_file' style='display: none' value='$id_file'>
                        <input type='text' name='id_permission' style='display:none' value='$id_permission'>
                        <input type='submit' value='Usuń'>
                        </form></td>";
                        echo "</tr>";
                    }
                }
                else
                    echo "<tr></tr><td colspan='2'>"."<h3>brak udostępnień!</h3>"."</td></tr>";
                ?>

            </table>

        </div>
    </div>
    <div class="col-3-10" id="col-right">
        <div class="invisible-container">
            <datalist id="friends_logins_list">
                <?php
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
                    echo "<option value='".htmlspecialchars($row['login'])."'>".htmlspecialchars($row['login'])."</option>";
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
                    else
                        document.getElementById("login_list").style.display='none';
                }
            </script>

            <form method="post" id="share_form" action="backend/file_share_add.php">
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
                <input id="submit-add-friend" type="submit" value="Udostępnij">
            </form>
        </div>
    </div>
</div>





