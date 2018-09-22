<?php
    session_start();
    if(isset($_POST["usun"]))    //usuwanie notatki
        {
            $nick = $_SESSION['user'];
            $notatka = $_POST['txt'];

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
                    if($polaczenie->query("DELETE FROM udostepnianie WHERE notatka = '$notatka' AND dla_kogo = '$nick'"))
                    {
                        $polaczenie->close();
                        $_SESSION['c_notatka']="Notatka została usunięta!";
                        header('Location: index_log.php');
                        exit();
                    }
                    else
                    {
                        throw new Exception($polaczenie->error);
                    }
                }

                $polaczenie->close();

            }   
            catch(Exception $e)
            {
                echo '<span style="color:red;">Błąd serwera! Prosimy spróbować pózniej!</span>';
                echo '<br />Informacja developerska: '.$e;
            }
        }


     if(!isset($_SESSION['zalogowany']))      //sprawdzenie czy już ktoś uruchomił sesje
     {   
        header('Location: index.php');
         exit();
     }
    
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Zalogowany</title>
        <link rel="Stylesheet" type="text/css" href="css/css-reset.css" />
        <link rel="Stylesheet" type="text/css" href="css/main.css" />
    </head>

    <body>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                $("a").on('click', function(event) { //Gładkie scrollowanie

                    if (this.hash !== "") {
                        event.preventDefault();
                        var hash = this.hash;
                        $('html, body').animate({
                            scrollTop: $(hash).offset().top
                        }, 800, function() {
                            window.location.hash = hash;
                        });
                    }
                });
            });

        </script>
        <?php include ('header_log_ar.php'); ?>
        <main>
            <div class="container">
                <div class="new_note_log">
                    <div class="container960px">
                
                    <?php                                                   //wyświetlenie wszystkich notatek
                        try 
                        {
                            require_once "connect.php";
                            mysqli_report(MYSQLI_REPORT_STRICT);

                            $polaczenie_w = new mysqli($host, $db_user, $db_password, $db_name);
                            if ($polaczenie_w->connect_errno!=0)
                            {
                                throw new Exception(mysqli_connect_errno());
                            }
                            else
                            {
                                $nick = $_SESSION['user'];
                                @$tytul = $_POST['text_name'];
                                @$notatka = $_POST['txt'];

                                $wynik = @$polaczenie_w->query("SELECT id, tytul, notatka, od_kogo FROM udostepnianie WHERE dla_kogo = '$nick'");
                                $i=0;
                                while($r = $wynik->fetch_assoc())
                                    { 
                                        $id[$i] = $r['id'];
                                        $tytul[$i] = $r['tytul'];
                                        $notatka[$i] = $r['notatka'];
                                        $od_kogo[$i] = $r['od_kogo'];
                                        $i++;
                                    }
                            }

                                $polaczenie_w->close();
                          }   
                          catch(Exception $e)
                          {
                             echo '<span style="color:red;">Błąd serwera! Prosimy spróbować pózniej!</span>';
                             echo '<br />Informacja developerska: '.$e;
                          }                  
                            $j=0;
                            if(isset($id))
                            {
                                ?>
                            <h1 id="h_index_log">Twoje udostępnione notatki:</h1>

                            <?php    
                                while($j < sizeof($id))
                                { 
                                    ?>
                                    <div class="note">
                                        <form method="POST" action="index_ar.php">
                                            <input type="hidden" name="oryg_notatka" value="<?php echo $notatka[$j]; ?>">
                                            <input id="text_name" type="text" name="who" value="<?php echo $od_kogo[$j]; ?>">
                                            <input id="text_name" type="text" name="text_name" placeholder="Wprowadź tytuł notatki" value="<?php echo $tytul[$j]; ?>">
                                            <textarea name="txt" rows='20' cols='91' placeholder="Tutaj wprowadź swój tekst"><?php echo $notatka[$j]; ?></textarea>

                                            <div class="download_txt">
                                                <button type="submit" name="usun">Usuń</button>
                                            </div>
                                        </form>
                                    </div>
                            <?php    
                                         $j++;
                                } 
                            }
                            else 
                            {
                                        ?>
                                <h1 id="h_index_log">Nie masz jeszcze żadnych udostępnionych notatek!</h1>
                        <?php
                            }
                                ?>

                </div>
            </div>
        </div>
            </main>
        </body>

        </html>
