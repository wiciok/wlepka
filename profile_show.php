<div class="row">
    <div class="col-8-10">
        <div class="innertube">
            <h2>
                Informacje o profilu
            </h2>
            <?php
            require_once "backend/connect_to_db.php";

            if(isset($_GET['id_user']) && !empty($_GET['id_user']))
            {
                $id_user=mysqli_real_escape_string($DB_link,$_GET['id_user']);

                $data=mysqli_query($DB_link,"select * from users where id_user='$id_user'");
                if(mysqli_num_rows($data)==0)
                {
                    echo "<h3>Brak profilu o podanym id!</h3>";
                }

                else
                {
                    $logged_user_row=mysqli_fetch_assoc($data);
                    echo "<h3>Imię:&nbsp &nbsp".htmlspecialchars($logged_user_row['name'])." </h3>";
                    echo "<h3>Nazwisko:&nbsp &nbsp".htmlspecialchars($logged_user_row['surname'])." </h3>";;
                    echo "<h3>Login:&nbsp &nbsp".htmlspecialchars($logged_user_row['login'])." </h3>";;


                    $id_country=$logged_user_row['id_country'];
                    $row=mysqli_fetch_assoc(mysqli_query($DB_link,"select name from countries where countries.id_country='$id_country'"));

                    echo "<h3>Kraj:&nbsp &nbsp".htmlspecialchars($row['name'])." </h3>";;

                    if(!empty($logged_user_row['birth_date']))
                        echo "<h3>Data urodzenia:&nbsp &nbsp".htmlspecialchars($logged_user_row['birth_date'])." </h3>";

                    if(!empty($logged_user_row['city']))
                        echo "<h3>Miasto:&nbsp &nbsp".htmlspecialchars($logged_user_row['city'])." </h3>";
                }
            }

            ?>
        </div>
    </div>
</div>