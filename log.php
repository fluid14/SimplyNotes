<?php

session_start();

require_once "connect.php";

$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

if($polaczenie->connect_errno!=0)
{
    echo "Error:".$polaczenie->connect_errno;
}else
{
    $login = $_POST['login'];
    $haslo = $_POST['haslo'];
    
    $login = htmlentities($login, ENT_QUOTES, "UTF-8"); // zmiana znaków na encje w razie SQL incjection
    
    if($rezultat = @$polaczenie->query(
        sprintf("SELECT * FROM uzytkownicy WHERE user='%s'",  //obrona przed SQL injection
               mysqli_real_escape_string($polaczenie,$login))))
    {
        $ilu_userow = $rezultat->num_rows;
        if($ilu_userow > 0) //szukamy czy taki user istnieje
        {
            $wiersz = $rezultat->fetch_assoc(); //wiersze do tablicy
                if(password_verify($haslo, $wiersz['pass']))
                {
                    $_SESSION['zalogowany'] = true;

                    $_SESION['id'] = $wiersz['id'];
                    $_SESSION['user'] = $wiersz['user'];
                    
                    unset($_SESSION['blad']);
                    $rezultat->free_result();
                    header('Location: index_log.php');
                }
                else //zle haslo
                {
                    $_SESSION['blad'] = '<span style ="color:red"><br> Nieprawidłowy login lub hasło!</span>';
                    header('Location: login.php');
                }

            }
            else //jeśli brak user
            {
                $_SESSION['blad'] = '<span style ="color:red"><br> Nieprawidłowy login lub hasło!</span>';
                header('Location: login.php');
            }
        }
        $polaczenie->close();
    }
    ?>