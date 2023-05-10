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
        echo('<li>Nombre de générations par partie en moyenne: ' . $avgGen . '</li>');
        echo('<li>Joueur ayant joué le plus de parties: ' . $mostPlayed['player'] . ', ' . 
            $mostPlayed['number'] . ' parties jouées</li>');
        echo('<li>Joueur ayant gagné le plus de parties: ' . $recordWinner['player'] . ', ' . 
            $recordWinner['number'] . ' parties gagnées</li>');




            
    ?>
</ul>