<?php
    if(isset($creation)){
        echo('<i>La partie a bien été enregistrée</i><br><br>');
    }
?>
<b><a href = "index.php?controller=Game&action=create">Enregistrer une partie</a></b>
<br><br><br>
<h2>Statistiques générales </h2>
<ul>
    <?php
        echo('<li>Nombre de parties jouées: ' . $nbGames .'</li>');
        echo('<li>Nombre de générations jouées: ' . $nbGenerations .'</li>');
        echo('<li>Nombre de générations par partie en moyenne: ' . $avgGen . '</li>');
        echo('<li>Partie la plus longue: ' . $maxGen . ' générations</li>');
        echo('<li>Partie la plus courte: ' . $minGen . ' générations</li>');
        echo('<li>Nombre de points marqués au total: ' . $nbPoints . '</li>');
        echo('<li>Nombre de points marqués en moyenne: ' . $avgPoints . '</li>');

     ?>
     <h3>Détail des points</h3>
    <?php
        if (!isset($pointDetails)){
            echo('Aucun points marqués');
        }
        else{
            echo('<table><tr><th>Catégorie</th><th>Total</th><th>Moyenne</th><th>Pourcentage</th></tr>');
            foreach($pointDetails as $pointDetail){
                echo('<tr><td>' . $pointDetail['description'] . '</td>');
                echo('<td>' . $pointDetail['score'] . '</td>');
                echo('<td>' . $pointDetail['avg'] . '</td>');
                echo('<td>' . round($pointDetail['proportion'] * 100, 2) . '%</td></tr>');
            }
            echo('</table>');
        }
    ?>   
</ul>
<h2>Statistiques sur les joueurs: </h2>
<ul>
    <h3>Global</h3>
    <ul>
    <?php
        echo('<li>Joueur ayant joué le plus de parties: ' . $mostPlayed['player'] . ', ' . 
            $mostPlayed['number'] . ' parties jouées</li>');
        echo('<li>Joueur ayant gagné le plus de parties: ' . $recordWinner['player'] . ', ' . 
            $recordWinner['number'] . ' parties gagnées</li>');
        foreach($recordTotalPoints as $record){
            echo('<li>Joueur ayant marqué le plus de points ' . $record['description'] . ': ' . $record['player'] . ', ' . 
            $record['number'] . ' points marqués (' . $record['nb_games'] . ' parties jouées)</li>');
        }
    ?>
    </ul>
    <h3>Sur une partie</h3>
    <ul>
        <?php
            foreach($recordPoints as $record){
                echo('<li>Joueur ayant le record de points ' . $record['description'] . ': ' . $record['player'] . ', ' . 
                $record['number'] . ' points marqués</li>');
            }
        ?>
    </ul>
    <h3>En moyenne</h3>
    <ul>
        <?php
            foreach($recordAvgPoints as $record){
                echo('<li>Joueur marquant le plus de points de ' . $record['description'] . ' en moyenne: ' . $record['player']
                 . ', ' . $record['number'] . ' points marqués par partie</li>');
            }
        ?>
    </ul>
</ul>
<h2>Statistiques sur les corporations: </h2>
<ul>
    <?php
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
<h2>Statistiques sur les objectifs & récompenses: </h2>
<ul>
<h3>Objectifs</h3>
    <?php
        echo('<table><tr><th>Objectif</th><th>Occurences</th><th>Fréquence</th>');
        foreach($goalStats as $goalStat){
            echo('<tr><td>' . $goalStat['goal'] . '</td>');
            echo('<td>' . $goalStat['count'] . '</td>');
            echo('<td>' . $goalStat['proportion'] . '%</td></tr>');
        }
        echo('</table>');
    ?>
<h3>Récompenses</h3>
    <?php
        echo('<table><tr><th>Récompense</th><th>Occurences</th><th>Fréquence</th>');
        foreach($awardStats as $awardStat){
            echo('<tr><td>' . $awardStat['award'] . '</td>');
            echo('<td>' . $awardStat['count'] . '</td>');
            echo('<td>' . $awardStat['proportion'] . '%</td></tr>');
        }
        echo('</table>');
    ?>
</ul>





