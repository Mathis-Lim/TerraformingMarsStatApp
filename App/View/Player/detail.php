<?php echo('<h1>' . $player->getName() . '</h1>'); ?>
<h2>Global</h2>
<ul>
    <?php
        echo('<li>' .$nbGames . ' parties jouées </li>');
        echo('<li>' . $avgGen . ' générations par parties en moyenne </li>');
        echo('<li>' .$nbVictories . ' parties gagnées </li>');
        echo('<li>' . round($freqVictory * 100, 2) . '% de parties gagnées </li>');
        echo('<li>' .$totalPoints . ' points marqués </li>');
        echo('<li>' . $avgPoints . ' points par parties en moyenne </li>');
        echo('<li>Corporation la plus choisie: ' . $mostChosenCorp['name']) . ' ' .
            round($mostChosenCorp['frequency'] * 100, 2) . '% sur ' .  $mostChosenCorp['total'] . ' parties</li>';
        echo('<li>Corporation la moins choisie: ' . $leastChosenCorp['name']) . ' ' .
            round($leastChosenCorp['frequency'] * 100, 2) . '% sur ' .  $leastChosenCorp['total'] . ' parties</li>';
    ?>
</ul>
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

<h2>Détail selon le type de partie</h2>
<?php
    $nbPlayers = 2;
    foreach($nbPlayerDetails as $nbPlayerDetail){
        if($nbPlayerDetail === 0){
            echo('<i>Aucune partie jouée</i>');
        }
        else{
            echo('<h3>Parties à ' . $nbPlayers . ' joueurs</h3>');
            echo('<ul><li>' . $nbPlayerDetail['nb_games'] . ' parties jouées</li>');
            echo('<li>' . $nbPlayerDetail['avg_game_time'] . ' générations par parties</li>');
            echo('<li>' . $nbPlayerDetail['total_score'] . ' points marqués</li></ul>');
            echo('<h4>Classement</h4>');
            echo('<p><table><tr><th>Classement</th><th>Occurences</th><th>Proportion</th>');
            foreach($nbPlayerDetail['rank'] as $rankDetail){
                echo('<tr><td>' . $rankDetail['position'] . '</td>');
                echo('<td>' . $rankDetail['total'] . '</td>');
                echo('<td>' . $rankDetail['proportion'] . '%</td></tr>');
            }
            echo('</table></p>');
            echo('<h4>Détail des points</h4>');
            echo('<p><table><tr><th>Catégorie</th><th>Total</th><th>Moyenne</th><th>Pourcentage</th></tr>');
            foreach($nbPlayerDetail['score'] as $scoreDetail){
                echo('<tr><td>' . $scoreDetail['description'] . '</td>');
                echo('<td>' . $scoreDetail['score'] . '</td>');
                echo('<td>' . $scoreDetail['avg'] . '</td>');
                echo('<td>' . round($scoreDetail['proportion'] * 100, 2) . '%</td></tr>');
            }
            echo('</table></p>');
        }
        $nbPlayers++;
    }
?>

<h2>Détail de la fréquence de choix des corporations</h2>
<table>
<?php    
    echo('<tr><th>Nom</th>');
    echo('<th>Fréquence de choix</th>');
    echo('<th>Nombre de choix</th></tr>');
    foreach($corporationChoices as $corporation){
        echo('<tr><td>' . $corporation['name'] . '</td>');
        echo('<td>' . round($corporation['frequency'] * 100, 2) . '%</td');
        echo('<td>' .$corporation['total'] . '</td></tr>');
    }
?>
</table>