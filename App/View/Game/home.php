<?php
    if($creation == true){
        echo('<i>La partie a bien été enregistrée</i>');
    }
?>
<b><a href = "index.php?controller=Game&action=create">Enregistrer une partie</a></b>
<br><br><br>
<ul>
    <?php
        echo('<li>Nombre de parties jouées: ' . $nbGames .'</li>');
        echo('<li>Nombre de générations jouées: ' . $nbGenerations .'</li>');
        echo('<li>Nombre de points marqués au total: ' . $nbPoints . '</li>');
        echo('<li>Nombre de points marqués en moyenne: ' . $avgPoints . '</li>');
    ?>
</ul>