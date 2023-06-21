<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $pageTitle; ?></title>
        <!--<link type="text/css" rel="stylesheet" href="view/style.css">-->
        <?php 
            if(isset($script)){
                echo(
                    '<script src=' . $script . '.js></script>'
                );
            }
        ?>    
    </head>
    <header>
        <b><u>Menu</u></b>
        <menu>
            <li><a href = "index.php?controller=Game&action=home">Accueil</a></li>
            <li><a href = "index.php?controller=Corporation&action=readAll">Corporations</a></li>
            <li><a href = "index.php?controller=Player&action=readAll">Joueurs</a></li>
            <li><a href = "index.php?controller=Extension&action=readAll">Extensions</a></li>
        </menu>
    </header>
    <body>
        <?php
            $filepath = File::build_path(array("View", $controller, "$view.php"));
            require $filepath;
        ?>
    </body>
    <footer>
        <h1>Quelque chose</h1>
    </footer>
</html>

