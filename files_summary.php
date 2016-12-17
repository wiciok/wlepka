<link rel="stylesheet" type="text/css" href="innerpages.css">
<link rel="stylesheet" type="text/css" href="friends.css">

<div class="row">
    <div class="col-10-10">
        <div class="innertube" id="div-table">
            <h2>Twoje pliki</h2>

            <table>
                <tr>
                    <th>Nazwa:</th>
                    <th>Język:</th>
                    <th>Usuń</th>
                    <th>Udostępnij</th>
                </tr>
                <tr>
                    <?php
                    require_once "connect_to_db.php";

                    $data=mysqli_query($DB_link,"SELECT files.name AS filename, languages.name AS langname, path FROM files,languages WHERE languages.id_lang=files.id_lang");
                    if(mysqli_num_rows($data)==0)
                        echo "<h3>Brak plików!</h3>";

                    else
                    {
                        for($i=mysqli_num_rows($data);$i>0;$i--)
                        {
                            $row=mysqli_fetch_assoc($data);

                            echo "<tr>";
                            echo "<td>"."<a target='_blank' href='".$row['path']."'>".$row['filename']."</a>"."</td>";
                            echo "<td>".$row['langname']."</td>";
                            echo "<td><button id='del_file' ".$row['langname']."</td>"; //tutaj zrobic usuwanie
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





