<?php

    session_start();

    if(isset($_POST['email']))
    {
        //Sprawdzenie walidacji
		$wszystko_OK=true;
		
		//Sprawdź poprawność nickname'a
		$nick = $_POST['login'];
		
		//Sprawdzenie długości nicka
		if ((strlen($nick)<3) || (strlen($nick)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_nick']="Nick musi posiadać od 3 do 20 znaków!";
		}
		
		if (ctype_alnum($nick)==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_nick']="Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
        
        //sprawdzenie email
        $email=$_POST['email'];
        $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
        
        if((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false || ($emailB!=$email)))
        {
            $wszystko_OK=false;
            $_SESSION['e_email'] = "Podaj poprawny email!";
        }
        
        //Sprawdzanie poprawnosci hasla
        $haslo1 = $_POST['haslo1'];
        $haslo2 = $_POST['haslo2'];
        
        if((strlen($haslo1) < 7) || (strlen($haslo1) > 20))
        {
            $wszystko_OK=false;
            $_SESSION['e_haslo'] = "Hasło musi posiadać od 7 do 20 znaków!";
        }
        
        if($haslo1!=$haslo2)
        {
            $wszystko_OK=false;
            $_SESSION['e_haslo'] = "Podane hasła nie są identyczne!";
        }
        
        $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
        
        
        //Checkbox regulamin
        if(!isset($_POST['regulamin']))
        {
            $wszystko_OK=false;
            $_SESSION['e_regulamin'] = "Musisz zaakceptować regulamin!";
        }
        
        //captcha
        $captcha_secret = "6LfJ610UAAAAABqXeUuzrSg_vApFGpY5NjwnXJ5J";
        $sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$captcha_secret.'&response='.$_POST['g-recaptcha-response']);
        $odpowiedz = json_decode($sprawdz);
        
        if($odpowiedz->success==false)
        {
            $wszystko_OK=false;
            $_SESSION['e_captcha'] = "Potwierdź, że nie jesteś botem!";
        }
        
        require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				//Czy email już istnieje?
				$rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
                
                $ilosc_mail = $rezultat->num_rows;
                if($ilosc_mail>0)
                {
                    $wszystko_OK=false;
                    $_SESSION['e_email'] = "Istnieje już konto z tym adresem email!";
                }
                
                //Czy nick już istnieje?
				$rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE user ='$nick'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
                
                $ilosc_user = $rezultat->num_rows;
                if($ilosc_user>0)
                {
                    $wszystko_OK=false;
                    $_SESSION['e_nick'] = "Istnieje już konto z taką nazwą użytkownika!";
                }
                
                 if ($wszystko_OK==true)
                {
                    if($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL, '$nick', '$haslo_hash', '$email')"))
                    {
                        $_SESSION['udanarejestracja']=true;
                        header('Location: login.php');
                    }
                     else
                    {
                        throw new Exception($polaczenie->error);
                    }
                }
                
                $polaczenie->close();
                
             }   
        }
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Prosimy spróbować pózniej!</span>';
			echo '<br />Informacja developerska: '.$e;
		}
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Notes - Rejestracja</title>
        <link rel="Stylesheet" type="text/css" href="css/css-reset.css" />
        <link rel="Stylesheet" type="text/css" href="css/main.css" />
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>

    <body>

        <?php include ('header.php'); ?>
        <main>
            <div class="container_login">
            </div>
            <div class="login">
                <aside>
                    <div class="login_form_reg">
                        <h1>Zarejestruj się lub <a id="bar_link" href="login.php"> Zaloguj</a></h1>
                        <div class="login_area">

                            <form method="POST">
                                <label for="login">Login<br></label>
                                <input type="text" placeholder="Wprowadź login" name="login">
                                <?php
                                        if (isset($_SESSION['e_nick']))
                                        {
                                            echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
                                            unset($_SESSION['e_nick']);
                                        }
                                    ?>

                                <label for="email"><br>Email</label>
                                <input type="text" placeholder="Wprowadź e-mail" name="email">
                                    <?php
                                        if (isset($_SESSION['e_email']))
                                        {
                                            echo '<div class="error">'.$_SESSION['e_email'].'</div>';
                                            unset($_SESSION['e_email']);
                                        }
                                    ?>

                                <label for="haslo1"><br>Haslo<br></label>
                                <input type="password" placeholder="Wprowadź hasło" name="haslo1">
                                <?php  
                                            if (isset($_SESSION['e_haslo']))
                                            {
                                                echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
                                                unset($_SESSION['e_haslo']);
                                            }
                                    ?>

                                <label for="haslo2"><br>Powtórz hasło<br></label>
                                <input type="password" placeholder="Powtórz hasło" name="haslo2">

                                <label><input type="checkbox" name="regulamin"  /> Akceptuję regulamin <br><br></label>
                                <?php  
                                         if (isset($_SESSION['e_regulamin']))
                                         {
                                             echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
                                              unset($_SESSION['e_regulamin']);
                                          }
                                     ?>

                                <div class="g-recaptcha" data-sitekey="6LfJ610UAAAAANgZKkOPHlKWINF0S_C1fcrMmSOR"></div> <br>

                                <?php  
                                        if (isset($_SESSION['e_captcha']))
                                        {
                                            echo '<div class="error">'.$_SESSION['e_captcha'].'</div>';
                                            unset($_SESSION['e_captcha']);
                                        }
                                    ?>
                                <button type="submit" name="rejestruj">Utwórz konto</button>
                                
                            </form>
                        </div>
                    </div>
                </aside>



            </div>
        </main>
    </body>

    </html>
