<link rel="stylesheet" type="text/css" href="innerpages.css">
<link rel="stylesheet" type="text/css" href="friends.css">

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
                        echo "Zaproszono znajomego!";
                        break;
                    case 2:
                        echo "Błąd podczas proby dodania znajomego!";
                        break;
                    case 3:
                        echo "Potwierdzono znajomego!";
                        break;
                    case 4:
                        echo "Błąd podczas proby potwierdzania znajomego!";
                        break;
                    case 5:
                        echo "Błąd podczas proby dodania znajomego!"."<br>"."Nie można być znajomym samego siebie!";
                        break;
                    case 6:
                        echo "Błąd podczas proby dodania znajomego!"."<br>"."Jesteście już znajomymi!";
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
    <div id="left-column" class="col-3-10">
        <div class="innertube">
            <h2>Znajomi</h2>
            <table>
                <tr>
                    <td>Login1:</td>
                    <td>Login2:</td>
                    <td>Status znajomości:</td>
                </tr>
                <?php
                require_once "connect_to_db.php";
                $id_user=mysqli_real_escape_string($DB_link,$_COOKIE['id_user']);

                $data=mysqli_query($DB_link, "SELECT DISTINCT id_user_1, id_user_2, status FROM friends WHERE id_user_1='$id_user' OR id_user_2='$id_user'");

                for($i=mysqli_num_rows($data);$i>0;$i--)
                {
                    $row=mysqli_fetch_assoc($data);
                    $id1=$row['id_user_1'];
                    $id2=$row['id_user_2'];
                    $status=$row['status'];
                    echo "
                    <tr>
                        <td>$id1</td>
                        <td>$id2</td>
                        <td>";

                    if($status=='unconfirmed' && $id1!=$id_user) //sytaucja kiedy nie jest potwierdzona znajomość i jesteśmy userem który został zaproszony
                    {
                        echo "
                        <form action=friend_confirm.php method='post'>
                        <input type='text' name='id_user_1' value='$id1' style='display: none'>
                        <input type='text' name='id_user_2' value='$id2' style='display: none'>
                        <input type='submit' name='' value='Potwierdź'>
                        </form>";
                    }

                    else
                        {
                            if($status=='unconfirmed')
                                echo "Znajomość niepotwierdzona";
                            else
                                echo "Znajomość potwierdzona";
                        }
                    echo"</td>
                    </tr>";
                }
                ?>
            </table>
        </div>
    </div>

    <div id="right-column" class="col-3-10">
        <div class="invisible-container">
            <datalist id="login_list">
                <?php
                require_once "connect_to_db.php";


                //todo: zmienic to zeby nie wyswietlali sie userzy ktorzy juz sa znajomymi
                $id_user=mysqli_real_escape_string($DB_link,$_COOKIE['id_user']);
                $data=mysqli_query($DB_link,"SELECT login FROM users WHERE login!=(SELECT login FROM users WHERE id_user='$id_user') ");
                $num_rows=mysqli_num_rows($data);

                while($num_rows>0)
                {
                    $row=mysqli_fetch_assoc($data);
                    echo htmlspecialchars('<option value='.$row['login'].'>');
                    $num_rows--;
                }
                ?>
            </datalist>
        </div>

        <div class="innertube">
            <h2>Dodaj znajomego</h2>

            <form method="post" action="friend_add.php">
                <input list="login_list" name="login" placeholder="wpisz login">
                <br>
                <input type="submit" value="Dodaj znajomego">
            </form>

        </div>
    </div>
</div>
