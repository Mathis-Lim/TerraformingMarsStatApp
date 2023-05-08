<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Erreur</title>
        <!--<link type="text/css" rel="stylesheet" href="view/style.css">-->  
    </head>
    <body>
        <p>
            <?php
                if(isset($errorMessage)){
                    echo($errorMessage);
                }
                else{
                    echo('Une erreur est survenue');
                }
            ?>
        </p>
        <p>
            <a href = "index.php?controller=Game&action=home">Retour à l'accueil</a>
        </p>
    </body>
</html>
