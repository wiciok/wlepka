<?php

function admin_check($link)
{
    if (isset($_COOKIE['id_user']))
    {
        $cookieID_user = mysqli_real_escape_string($link, $_COOKIE['id_user']);

        $data = mysqli_query($link, "
        SELECT user_type 
        FROM users, current_sessions
        WHERE current_sessions.id_user='$cookieID_user' 
        AND users.id_user=current_sessions.id_user");

        $row=mysqli_fetch_assoc($data);

        if($row['user_type']=='admin')
            return true;
        else
            return false;
    }
    else
        return false;
}


?>