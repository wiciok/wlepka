<link rel="stylesheet" type="text/css" href="innerpages.css">
<link rel="stylesheet" type="text/css" href="fileadd.css">

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
                        echo "Poprawnie przesłano plik!";
                        break;
                    case 2:
                        echo "Błąd podczas próby przesyłania pliku!"."<br>"."Plik o danej nazwie już istnieje na Twoim koncie!";
                        break;
                    case 3:
                        echo "Błąd podczas próby przesyłania pliku!"."<br>"."Plik ma zbyt duży rozmiar!";
                        break;
                    case 4:
                        echo "Błąd podczas próby przesyłania pliku!"."<br>"."Blad przesyłania pliku lub dodawania wpisu do bazy danych!";
                        break;
                    case 5:
                        echo "Błąd podczas próby przesyłania pliku!"."<br>"."Blad przesyłania danych!";
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
    <script>
        function checkSubmitButton()
        {
            function col1() {document.getElementById('send').style.backgroundColor="#3d7829"}
            function col2(){document.getElementById('send').style.backgroundColor="#5a9f33"}

            if(document.getElementById('file_checker').value != '')
            {
                col2();
                document.getElementById('send').addEventListener("mouseover",col1);
                document.getElementById('send').addEventListener("mouseout",col2);
                document.getElementById('filename_shower').value=document.getElementById('file_checker').value;
                document.getElementById('button_add_file').style.display='none';
                document.getElementById('filename_shower').style.display='inherit';
            }
        }
    </script>

    <div class="col-4-10">
        <h2>Dodaj plik</h2>
        <form action="file_upload.php" method="post" onsubmit="return document.getElementById('file_checker').value != ''" enctype="multipart/form-data">
            Wybierz plik do przesłania (max. rozmiar <?php include_once "file_constants.php"; echo $FILE_MAX_SIZE/1000 .'kB'; ?>):
            <br><br>
            <input type="file" name="file" id="file_checker" style="display: none">

            <!--todo: zmienic to mouseover na cos lepszego -->
            <input type="text" value="wybierz plik..." readonly id="filename_shower">
            <button id="button_add_file" onclick="document.getElementById('file_checker').click()" onmouseover="checkSubmitButton()">Wybierz plik</button>
            <br><br>
            Wybierz język:<br>
            <select name="lang_name">
                <?php
                require_once "connect_to_db.php";

                $data=mysqli_query($DB_link,"SELECT name FROM languages;");
                $num_rows=mysqli_num_rows($data);

                while($num_rows>0)
                {
                    $row=mysqli_fetch_assoc($data);
                    echo '<option>'.$row['name'].'</option>';
                    $num_rows--;
                }
                ?>
            </select>
            <br>
            <input type="submit" value="Prześlij" name="submit" id="send">
        </form>
    </div>
</div>