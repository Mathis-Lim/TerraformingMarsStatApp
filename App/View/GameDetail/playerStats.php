<h1>Statistiques sur les joueurs: </h1>
<ul>
    <h2>Global</h2>
    <ul>
    <?php
        echo('<li>Joueur ayant joué le plus de parties: ' . $mostPlayed['player'] . ', ' . 
            $mostPlayed['number'] . ' parties jouées</li>');
        echo('<li>Joueur ayant gagné le plus de parties: ' . $recordWinner['player'] . ', ' . 
            $recordWinner['number'] . ' parties gagnées (' . $recordWinner['nb_games'] . ' parties jouées)</li>');
        echo('<li>Joueur ayant le meilleur ratio de victoire: ' . $recordWinrate['player'] . ', ' . $recordWinrate['record'] . 
            '% de victoire (' . $recordWinrate['nb_games'] . ' parties jouées)</li>');
    ?>
    </ul>
    <h2>Détail selon le nombre de joueur</h2>
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
                    echo('<li>Joueur ayant le record de points ' . $record['description'] . ': ' . $record['player'] . ', ' . 
                    $record['number'] . ' points marqués (' . $record['nb_games'] . ' parties jouées)</li>');
                }
                echo('</ul>');
                
                echo('<h4>En moyenne</h4>');
                echo('<ul>');
                echo('<li>Joueur ayant le meilleur ratio de victoire: ' . $detail['winrate_record']['player'] . ', ' . 
                    $detail['winrate_record']['record'] . '% de victoire (' . $detail['winrate_record']['nb_games'] .
                    ' parties jouées)</li>');
                foreach($detail["avg_point_records"] as $record){
                    echo('<li>Joueur marquant le plus de points ' . $record['description'] . ' en moyenne: ' . $record['player']
                    . ', ' . $record['number'] . ' points marqués par partie (' . $record['nb_games'] . ' parties jouées)</li>');
                }
                echo('</ul>');
            }
            $nbPlayers++;
        }  
    ?>