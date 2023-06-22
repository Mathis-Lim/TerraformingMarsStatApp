<h1>Statistiques sur les joueurs: </h1>
<ul>
    <h2>Global</h2>
    <ul>
    <?php
        echo('<li>Joueur ayant joué le plus de parties: ' . $mostPlayed['player'] . ', ' . 
            $mostPlayed['number'] . ' parties jouées</li>');
        echo('<li>Joueur ayant gagné le plus de parties: ' . $recordWinner['player'] . ', ' . 
            $recordWinner['number'] . ' parties gagnées (' . $recordWinner['nb_games'] . ' parties jouées)</li>');
        foreach($recordTotalPoints as $record){
            echo('<li>Joueur ayant marqué le plus de points ' . $record['description'] . ': ' . $record['player'] . ', ' . 
            $record['number'] . ' points marqués (' . $record['nb_games'] . ' parties jouées)</li>');
        }
    ?>
    </ul>
    <h3>En moyenne</h3>
    <ul>
        <?php
            foreach($recordAvgPoints as $record){
                echo('<li>Joueur marquant le plus de points de ' . $record['description'] . ' en moyenne: ' . $record['player']
                 . ', ' . $record['number'] . ' points marqués par partie (' . $record['nb_games'] . ' parties jouées)</li>');
            }
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
            }


            $nbPlayers++;
        }

        
    ?>
