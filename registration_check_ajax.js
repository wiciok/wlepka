function checkInDatabase(field, value)
{
    try
    {
        switch(field)
        {
            case "login":
                if(value!='')
                {
                    if (window.XMLHttpRequest)
                    {
                        xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function()
                        {
                            if (this.readyState == 4 && this.status == 200)
                            {
                                //alert(xmlhttp.responseText);
                                //alert(xmlhttp.responseText.indexOf("true"));
                                if(xmlhttp.responseText.indexOf("true")!=-1)
                                    document.getElementById("input-login").style.border="2px solid darkgreen";
                                else
                                {
                                    if(xmlhttp.responseText.indexOf("false")!=-1)
                                        document.getElementById("input-login").style.border="2px solid darkred";
                                    else
                                        throw new XMLHttpRequestException("Nieprawidłowa odpowiedź na zapytanie!");
                                }
                            }
                        };

                        xmlhttp.open("POST","backend/ajax_data_check.php",true);
                        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xmlhttp.send("login="+value);
                    }
                    else
                        throw new XMLHttpRequestException("Przeglądarka nie obsługuje AJAXa!");
                }
                else
                    document.getElementById("input-login").style.border="2px solid darkred";

                break;

            case "password":
                if(value!='')
                    document.getElementById("input-password").style.border="2px solid darkgreen";
                else
                    document.getElementById("input-password").style.border="2px solid darkred";
                break;
            default:
                break;
        }
    }
    catch(e) //używamy diva JSValidatora, żeby nie tworzyć specjalnie tylko w tym celu diva alert
    {
        document.getElementById("JSValidator").style.display="inherit";
        document.getElementById("JSValidator").write("<h3>Błąd AJAX! </h3>"+e.message);
    }

}