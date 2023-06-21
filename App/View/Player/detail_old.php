<?php echo('<h2>' . $player->getName() . '</h2>'); ?>
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
<h3>Détail du classement selon le type de partie</h3>
<?php
    $nbPlayersRank = 2;
    foreach($positionDetails as $positionDetail){
        echo('<h4>Parties à ' . $nbPlayersRank . ' joueurs</h4>');
        if($positionDetail === 0){
            echo('<i>Aucune partie jouée</i>');
        }
        else{
            echo('<table><tr><th>Classement</th><th>Occurences</th><th>Proportion</th>');
            foreach($positionDetail as $detail){
                echo('<tr><td>' . $detail['position'] . '</td>');
                echo('<td>' . $detail['total'] . '</td>');
                echo('<td>' . $detail['proportion'] . '%</td></tr>');
            }
            echo('</table>');
        }
        $nbPlayersRank++;
    }
?>
<h3>Détail de la fréquence de choix des corporations</h3>
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