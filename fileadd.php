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
                    case 6:
                        echo "Błąd podczas próby przesyłania pliku!"."<br>"."Niepoprawna nazwa pliku!";
                        break;
                    case 7:
                        echo "Błąd podczas próby przesyłania pliku!"."<br>"."Plik nie jest plikiem tekstowym!";
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
        function escapeHtml(text) {
            var map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };

            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }

        function col1()
        {
            document.getElementById('send').style.backgroundColor='#3d7829'
        }
        function col2()
        {
            document.getElementById('send').style.backgroundColor='#5a9f33'
        }

        function resetControls()
        {
            document.getElementById('send').style.backgroundColor='#707070';
            document.getElementById('send').removeEventListener('mouseover',col1);
            document.getElementById('send').removeEventListener('mouseout',col2);
            document.getElementById('send').disabled=true;
            document.getElementById('filename_shower').style.display='none';
            document.getElementById('file_checker').value='';
            document.getElementById('file_checker').click();
        }

        function checkSubmitButtonAfterSelection()
        {
            if(document.getElementById('file_checker').value != '' && document.getElementById("select_lang").value!='not_chosen')
            {
                col2();
                document.getElementById('send').addEventListener('mouseover',col1);
                document.getElementById('send').addEventListener('mouseout',col2);
                document.getElementById('send').disabled=false;
                clearInterval(check);
            }
        }

        function updateFilenameShower()
        {
            document.getElementById('filename_shower').value=escapeHtml(document.getElementById('file_checker').value);
            document.getElementById('filename_shower').style.display='inherit';
        }
    </script>

    <div class="col-4-10">
        <h2>Dodaj plik</h2>
        <form action="backend/file_upload.php" method="post" onsubmit="return document.getElementById('file_checker').value != ''" enctype="multipart/form-data">
            Wybierz plik do przesłania (max. rozmiar <?php require_once "backend/file_constants.php"; echo $FILE_MAX_SIZE/1000 .'kB'; ?>):
            <br><br>
            <input type="file" name="file" id="file_checker" style="display: none">

            <input type="text" value="wybierz plik..." readonly id="filename_shower">
            <button id="button_add_file" onclick="resetControls(); check=setInterval(function(){updateFilenameShower()},1000)">Wybierz plik</button>
            <br><br>
            Wybierz język:<br>
            <select name="lang_name" id="select_lang" onchange="checkSubmitButtonAfterSelection()">
                <option value="not_chosen" selected="selected" disabled="disabled">-wybierz-</option>
                <?php
                require_once "backend/connect_to_db.php";

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
            <input type="submit" value="Prześlij" name="submit" id="send" disabled="disabled">
        </form>
    </div>
</div>