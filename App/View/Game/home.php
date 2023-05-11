<?php
    if(isset($creation)){
        echo('<i>La partie a bien été enregistrée</i><br><br>');
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
        echo('<li>Joueur ayant marqué le plus de points: ' . $recordPoints['player'] . ', ' . 
            $recordPoints['number'] . ' points marqués</li>');
        echo('<li>Corporation la plus choisie: ' . $mostChosenCorp['name']) . ' ' .
            round($mostChosenCorp['frequency'] * 100, 2) . '% sur ' .  $mostChosenCorp['total'] . ' parties</li>';
        echo('<li>Corporation la moins choisie: ' . $leastChosenCorp['name']) . ' ' .
            round($leastChosenCorp['frequency'] * 100, 2) . '% sur ' .  $leastChosenCorp['total'] . ' parties</li>';    
        echo('<li>Corporation ayant gagné le plus de parties: ' . $recordWinnerCorporation['corporation'] . ', ' . 
            $recordWinnerCorporation['number'] . ' parties gagnées</li>');
        echo('<li>Corporation ayant marqué le plus de points: ' . $recordPointsCorporation['corporation'] . ', ' . 
            $recordPointsCorporation['number'] . ' points marqués</li>');   
        
    ?>
</ul>


