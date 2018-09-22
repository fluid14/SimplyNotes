<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notes - Twoje notatki zawsze z Tobą!</title>
    <link rel="Stylesheet" type="text/css" href="css/css-reset.css" />
    <link rel="Stylesheet" type="text/css" href="css/main.css" />
</head>

<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
      $("a").on('click', function(event) {              //Gładkie scrollowanie

        if (this.hash !== "") 
        {
          event.preventDefault();
          var hash = this.hash;
          $('html, body').animate({
            scrollTop: $(hash).offset().top
          }, 800, function(){
            window.location.hash = hash;
          });
        }
      });
    });
    </script>

    <?php include ('header_login.php'); ?>
    <main>
        <div class="container">
            <div id="new_note" class="new_note">
                <div class="container960px">
                    <h1 id="h_index">Twoje notatki zawsze z Tobą!</h1>
                    <p id="p_index">Zapisuj wszystko co przyjdzie Ci do głowy!</p>
                    
                    <form action="register.php">
                    <button type="submit">Wypróbuj teraz!</button>
                    </form>
                </div>
            </div>

            <div id="about" class="about">
                <div class="container960px">
                    <h1 id="h_index">Notatki zawsze wtedy gdy ich potrzebujesz!</h1>
                    <p id="p_index">Gdziekolwiek jesteś!</p>
                    
                    <h1 id="h_index_left">Twórz, edytuj, usuwaj!</h1>
                    <p id="p_index_left">Jak tylko chcesz</p>
                    
                    <form action="register.php">
                    <button type="submit">Wypróbuj teraz!</button>
                    </form>
                </div>
            </div>

            <div id="rules" class="rules">
                <div class="container960px">
                    <h1 id="h_index">And this is the year 2015? October 21st 2015. God, so like you weren't kidding! Marty, we can actually see our futures! (to Doc) Doc, you said we were married, right?</h1>
                    <h1 id="h_index">(The board blasts off. Griff and his gang are on the way! Marty tries pushing the board again, but it doesn't work. Griff is getting closer. </h1>

                </div>
            </div>
        </div>
    </main>

</body>

</html>
