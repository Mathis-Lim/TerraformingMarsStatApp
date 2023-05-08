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
        <h1>Menu</h1>
    </header>
    <body>
        <?php
            $filepath = File::build_path(array("view", $controller, "$view.php"));
            require $filepath;
        ?>
    </body>
    <footer>
        <h1>Quelque chose</h1>
    </footer>
</html>

