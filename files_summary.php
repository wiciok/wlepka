<link rel="stylesheet" type="text/css" href="innerpages.css">
<link rel="stylesheet" type="text/css" href="files_summary.css">

<!-- todo: alert z obsługą błędow! m.in. blad usuwania pliku -->

<div class="row">
    <div class="col-10-10">
        <div class="innertube" id="div-table">
            <h2>Twoje pliki</h2>

            <table>
                <tr>
                    <th>Nazwa:</th>
                    <th>Język:</th>
                    <th>Akcje:</th>
                </tr>
                <tr>
                    <?php
                    require_once "connect_to_db.php";

                    $id_user=mysqli_real_escape_string($DB_link,$_COOKIE['id_user']);
                    $data=mysqli_query($DB_link,"SELECT files.name AS filename, languages.name AS langname, id_file , path FROM files,languages WHERE languages.id_lang=files.id_lang AND files.id_user='$id_user'");
                    if(mysqli_num_rows($data)==0)
                        echo "<h3>Brak plików!</h3>";

                    else
                    {
                        for($i=mysqli_num_rows($data);$i>0;$i--)
                        {
                            $row=mysqli_fetch_assoc($data);

                            echo "<tr>";
                            echo "<td width='70%'>"."<a target='_blank' href='".$row['path']."'>".$row['filename']."</a>"."</td>";
                            echo "<td width='15%'>".$row['langname']."</td>";
                            echo "<td width='15%'>";
                            echo "
                            <a href='mainpage.php?page=file_properties&id_file=".$row['id_file']."'><button>Właściwości</button>                            
                            ";

                            echo "</tr>";
                        }


                    }

                    ?>
                </tr>

            </table>
        </div>



        <div class="innertube" id="div-table">
            <h2>Udostępnione pliki</h2>

            <table>
                <tr>
                    <th>Nazwa:</th>
                    <th>Język:</th>
                    <th>Właściciel</th>
                </tr>
                <tr>

                </tr>

            </table>
        </div>
    </div>
</div>





