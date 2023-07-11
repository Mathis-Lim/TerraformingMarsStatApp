<h1>Statistiques sur les corporations: </h1>
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

<?php
        $nbPlayers = 2;
        foreach($nbPlayerDetails as $detail){
            echo('<h3>Parties de ' . $nbPlayers . ' joueurs</h3>');
            if($detail === 0){
                echo('<i>Aucune partie jouée</i>');
            }
            else{
                echo('<h4>Sur une partie</h4>');
                echo('<ul>');
                foreach($detail["point_records"] as $record){
                    echo('<li>Corporation ayant le record de points ' . $record['description'] . ': ' . $record['player'] . ', ' . 
                    $record['number'] . ' points marqués (' . $record['nb_games'] . ' parties jouées)</li>');
                }
                echo('</ul>');

                echo('<h4>Score moyen des vainqueurs</h4>');
                echo('<p><table><tr><th>Type points</th><th>Score</th><th>Pourcentage</th></tr>');
                foreach($detail['winner_stats'] as $winnerScore){
                    echo('<tr><td>' . $winnerScore['description'] . '</td><td>' . $winnerScore['score'] . '</td><td>' . 
                        $winnerScore['proportion'] . '%</td></tr>');
                }
                echo('</table></p>');
                
                echo('<h4>En moyenne</h4>');
                echo('<ul>');
                echo('<li>Corporation ayant le meilleur ratio de victoire: ' . $detail['winrate_record']['player'] . ', ' . 
                    $detail['winrate_record']['record'] . '% de victoire (' . $detail['winrate_record']['nb_games'] .
                    ' parties jouées)</li>');
                foreach($detail["avg_point_records"] as $record){
                    echo('<li>Corporation marquant le plus de points ' . $record['description'] . ' en moyenne: ' . $record['player']
                    . ', ' . $record['number'] . ' points marqués par partie (' . $record['nb_games'] . ' parties jouées)</li>');
                }
                echo('</ul>');
            }
            $nbPlayers++;
        }  
    ?>