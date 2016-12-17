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
                    case 7:
                        echo "Usunięto znajomość!";
                        break;
                    case 8:
                        echo "Błąd podczas proby usuwania znajomości!";
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
    <div id="left-column" class="col-7-10">
        <div class="innertube" id="div-table">
            <h2>Znajomi</h2>
            <table>
                <?php
                require_once "connect_to_db.php";

                $id_user=mysqli_real_escape_string($DB_link,$_COOKIE['id_user']);
                $data=mysqli_query($DB_link, "SELECT DISTINCT id_user_1, id_user_2, status FROM friends WHERE id_user_1='$id_user' OR id_user_2='$id_user'");

                if(mysqli_num_rows($data)==0)
                    echo "<h3>Nie masz żadnych znajomych!</h3>";

                else
                {
                    echo"
                    <tr>
                        <th>Login:</th>
                        <th>Imie:</th>
                        <th>Nazwisko:</th>
                        <th>Status znajomości:</th>
                        <th></th>
                    </tr>";

                    for($i=mysqli_num_rows($data);$i>0;$i--)
                    {
                        $row=mysqli_fetch_assoc($data);
                        $id1=$row['id_user_1']; //user ktory dodawal znajomosc
                        $id2=$row['id_user_2']; //user, ktory potwierdza znajomosc
                        $status=$row['status'];

                        if($id1==$id_user)
                        {
                            $detailed_user_data=mysqli_query($DB_link,"SELECT login, name, surname FROM users WHERE id_user='$id2'");
                            $id_other_user=$id2;
                        }

                        else
                        {
                            $detailed_user_data=mysqli_query($DB_link,"SELECT login, name, surname FROM users WHERE id_user='$id1'");
                            $id_other_user=$id1;
                        }

                        $detailed_user_data=mysqli_fetch_assoc($detailed_user_data);
                        $tmp_login=$detailed_user_data['login'];
                        $tmp_name=$detailed_user_data['name'];
                        $tmp_surname=$detailed_user_data['surname'];


                        echo "
                        <tr>
                            <td><a href='mainpage.php?page=profile_show&id_user=".$id_other_user."'>$tmp_login</a></td>
                            <td>$tmp_name</td>
                            <td>$tmp_surname</td>
                            <td>";

                        if($status=='unconfirmed' && $id1!=$id_user) //sytaucja kiedy nie jest potwierdzona znajomość i jesteśmy userem który został zaproszony
                        {
                            echo "Znajomość niepotwierdzona"."</td>";
                            echo "
                            <td>
                                <form action=friend_confirm.php method='post'>
                                <input type='text' name='id_user_1' value='$id1' style='display: none'>
                                <input type='text' name='id_user_2' value='$id2' style='display: none'>
                                <input type='submit' name='' value='Potwierdź'>
                                </form>
                            </td>";
                        }

                        else
                        {
                            if($status=='unconfirmed')
                                echo "Znajomość niepotwierdzona"."</td>";
                            else
                                echo "Znajomość potwierdzona"."</td>";

                            echo "
                            <td>
                                <form action=friend_delete.php method='post'>
                                <input type='text' name='id_user_1' value='$id1' style='display: none'>
                                <input type='text' name='id_user_2' value='$id2' style='display: none'>
                                <input type='submit' name='' value='Usuń'>
                                </form>
                            </td>";
                        }
                        echo"
                        </tr>";
                    }
                }?>
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
                <input id="submit-add-friend" type="submit" value="Dodaj znajomego">
            </form>
        </div>
    </div>
</div>
