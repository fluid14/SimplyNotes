<?php
    session_start();

if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
{
    header('Location: index_log.php');
    exit();
}

if(isset($_SESSION['udanarejestracja']))
{
    $_SESSION['c_reg'] = "Dziękujemy za rejestracje, teraz możesz się zalogować!";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notes - Twoje notatki</title>
    <link rel="Stylesheet" type="text/css" href="css/css-reset.css" />
    <link rel="Stylesheet" type="text/css" href="css/main.css" />
</head>

<body>
    <?php include ('header.php'); ?>
    <main>
        <div class="container_login">
        </div>
        <div class="login">
            <aside>
                <div class="login_form_reg">
            <?php
			if (isset($_SESSION['c_reg']))
			{
				echo '<div class="error">'.$_SESSION['c_reg'].'</div>';
				unset($_SESSION['c_reg']);
			}
		?>
                    <h1> Zaloguj lub <a id="bar_link" href="register.php">Zarejestruj się!</a></h1>
                    <div class="login_area">
                        <form method="POST" action="log.php">
                            <label for="login">Login<br></label>
                            <input type="text" placeholder="Wprowadź login" name="login" required>

                            <label for="password"><br>Hasło<br></label>
                            <input type="password" placeholder="Wprowadź hasło" name="haslo" required>

                            <button type="submit" name="loguj">Zaloguj</button>
                            
                            <?php
                                if(isset($_SESSION['blad'])) echo $_SESSION['blad'];
                            ?>
                        </form>
                    </div>
                </div>
            </aside>



        </div>
    </main>
</body>

</html>
