<link rel="stylesheet" type="text/css" href="innerpages.css">
<link rel="stylesheet" type="text/css" href="files_summary.css">


<div id="div-alert">
    <div class="innertube">
        <h3 id="div-alert-h3">
            <?php
            if(isset($_GET['alert']) && !empty($_GET['alert']))
            {
                echo "<script>document.getElementById('div-alert').style.display='inherit'</script>";

                switch($_GET['alert'])
                {
                    case 1:
                        echo 'Błąd usuwania pliku!';
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
                    require_once "backend/connect_to_db.php";

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
                    <th>Właściciel:</th>
                    <th>Akcja:</th>
                </tr>
                    <?php
                    try
                    {
                        $data=mysqli_query($DB_link,"
                    SELECT id_file FROM shares, friends     /*read / read/write friends*/
                    WHERE 
                      (
                        (shares.id_user=friends.id_user_1 AND friends.id_user_2='$id_user')
                        OR (shares.id_user=friends.id_user_2 AND friends.id_user_1='$id_user')
                      ) 
                     AND friends.status='confirmed' 
                     AND (shares.id_permission=1 OR shares.id_permission=2)
                     
                    UNION   /*read_all*/
                      SELECT id_file FROM shares WHERE id_permission=3 AND id_user!='$id_user'
                      
                    UNION   /*read / read/write user*/
                      SELECT id_file FROM shares, permissions 
                      WHERE shares.id_permission=permissions.id_permission 
                      AND shares.id_permission>3 
                      AND id_shared_user='$id_user'
                    ");

                        for($i=mysqli_num_rows($data);$i>0;$i--)
                        {
                            $row=mysqli_fetch_assoc($data);
                            $id_file=$row['id_file'];

                            $data2=mysqli_query($DB_link,"
                            SELECT path, files.name AS filename, languages.name AS langname, users.login AS owner 
                            FROM files 
                            LEFT JOIN users ON files.id_user=users.id_user 
                            LEFT JOIN languages ON files.id_lang=languages.id_lang 
                            WHERE files.id_file='$id_file'");

                            if(mysqli_num_rows($data2)!=1)
                                throw new mysqli_sql_exception();
                            $row=mysqli_fetch_assoc($data2);

                            echo "<tr>";
                            echo "<td><a href='".$row['path']."'>".$row['filename']."</a></td>";
                            echo "<td>".$row['langname']."</td>";
                            echo "<td>".$row['owner']."</td>";

                            $data3=mysqli_query($DB_link,"
                            SELECT permission_name, id_shared_user 
                            FROM permissions, shares
                            WHERE shares.id_permission=permissions.id_permission
                            AND shares.id_file='$id_file';
                            ");

                            $flag=0;
                            for($j=mysqli_num_rows($data3);$j>0;$j--)
                            {
                                $row=mysqli_fetch_assoc($data3);
                                if($row['permission_name']==='read_write_friends')
                                    $flag=1;
                                if($row['permission_name']==='read_write_user' && $row['id_shared_user']===$id_user)
                                    $flag=1;
                            }

                            if($flag===1)
                                echo "<td><a href='mainpage.php?page=file_properties&id_file=".$id_file."'><button>Właściwości</button></td>";

                            if(mysqli_error($DB_link))
                                throw new mysqli_sql_exception();

                            echo "</tr>";
                        }
                    }
                    catch(Exception $e)
                    {
                        //echo $e->getMessage();
                        //header("location: mainpage.php?page=file_summary&alert=2");
                        echo"
                        <script>
                        document.getElementById('div-alert').style.display='inherit';
                        document.getElementById('div-alert-h3').innerHTML='Blad wyświetlania udostepnień!';
                        </script>
                        ";
                        exit;
                    }

                    ?>

            </table>
        </div>
    </div>
</div>





