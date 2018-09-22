<!--Wyświetla gdy użytkownik jest zalogowany-->
<header class="header_login">

    <nav>
        <a href="index_log.php"><img class="logo" src="images/logo.png" alt="LOGO" style="width:180px; height:45px;"></a>
        <ul>
            <li><a id="bar_link" href="index_log.php#new_note">Nowa notatka</a></li>
            <li><a id="bar_link" href="index_log.php#about">Moje notatki</a></li>
            <li><a id="bar_link" href="index_ar.php">Notatki udostępnione dla mnie</a></li>
        </ul>  
          
        <a id="show_logout" href="logout.php">Wyloguj</a>
        <a id="show_login"><?php echo "<p> Witaj ".$_SESSION['user']."!"; ?></a>
    </nav>

</header>
