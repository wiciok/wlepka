<link rel="stylesheet" type="text/css" href="innerpages.css">
<link rel="stylesheet" type="text/css" href="profileedit.css">



<div id="column" class="col-6-10">
    <div id="div-alert">
        <div class="innertube">
            <h3>
                <?php
                if(isset($_GET['alert']) && !empty($_GET['alert']))
                {
                    echo "<script>document.getElementById('div-alert').style.display='inherit'</script>";

                    switch($_GET['alert'])
                    {
                        case 1:
                            echo "Zmieniono dane!";
                            break;
                        case 2:
                            echo "Błąd podczas proby zmiany danych!";
                            break;
                        case 3:
                            echo "Błąd! Login zajęty!";
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

    <div class="innertube">
        <h2>Edytuj Profil</h2>
        <h3>Wpisz zawartość w pola, które chcesz edytować. Jeśli nie chcesz zmieniać jakiejś danej, pozostaw puste pole.<br></h3>

        <form method="post" action="user_edit.php">
            <table>
                <tr>
                    <td>Imię:</td>
                    <td>
                        <input type="text" name="name" placeholder="<?php
                        require_once "connect_to_db.php";
                        $logged_id_user=mysqli_real_escape_string($DB_link,$_COOKIE['id_user']);
                        $logged_user_row=mysqli_fetch_assoc(mysqli_query($DB_link,"select * from users where id_user='$logged_id_user'"));

                        echo htmlspecialchars($logged_user_row['name']);
                        ?>">
                    </td>
                </tr>
                <tr>
                    <td>Nazwisko:</td>
                    <td><input type="text" name="surname" placeholder="<?php global $logged_user_row; echo htmlspecialchars($logged_user_row['surname']); ?>"></td>
                </tr>
                <tr>
                    <td>Login:</td>
                    <td><input type="text" name="login" placeholder="<?php global $logged_user_row; echo htmlspecialchars($logged_user_row['login']); ?>"></td>
                </tr>
                <tr>
                    <td>Hasło:</td>
                    <td><input type="password" name="password" placeholder="wpisz tutaj nowe hasło"></td>
                </tr>
                <tr>
                    <td>Kraj:</td>

                    <div class="invisible-container">
                        <datalist id="countries">
                            <?php
                            require_once "connect_to_db.php";

                            $data=mysqli_query($DB_link,"SELECT name FROM countries");
                            $num_rows=mysqli_num_rows($data);

                            while($num_rows>0)
                            {
                                $row=mysqli_fetch_assoc($data);
                                echo htmlspecialchars('<option value='.$row['name'].'>');
                                $num_rows--;
                            }
                            ?>
                        </datalist>
                    </div>

                    <?php
                    global $logged_id_user;
                    global $logged_user_row;
                    $id_country=$logged_user_row['id_country'];
                    $row=mysqli_fetch_assoc(mysqli_query($DB_link,"select name from countries where countries.id_country='$id_country'"));
                    ?>
                    <td>
                        <input list="countries" name="country" placeholder="<?php global $row; echo htmlspecialchars($row['name']);?>"/>
                    </td>
                </tr>
                <tr>
                    <td>Data urodzenia:</td>
                    <td><input type="text" name="birth_date" placeholder="<?php
                        global $logged_user_row;
                        if(!empty($logged_user_row['birth_date']))
                            echo htmlspecialchars($logged_user_row['birth_date']);
                        else
                            echo "Wpisz datę w formacie YYYY-MM-DD";
                        ?>"></td>
                </tr>
                <tr>
                    <td>Miasto:</td>
                    <td><input type="text" name="city" list="mojalista" placeholder="<?php global $logged_user_row; echo htmlspecialchars($logged_user_row['city']); ?>"></td>
                </tr>
                <tr>
                    <td>
                        <br>
                    </td>
                </tr>
                <tfoot>
                <tr>
                    <td colspan="2">
                        <input type="submit" value="Wyślij">
                    </td>
                </tr>
                </tfoot>
            </table>
        </form>
    </div>
</div>
