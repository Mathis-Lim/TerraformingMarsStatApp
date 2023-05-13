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
<?php echo('<h3> Détails de la fréquence de choix des corporations </h3>'); ?>
<tbody>
<?php    
    echo('<tr><th>Nom</th>');
    echo('<th>Fréquence de choix</th>');
    echo('<th>Nombre de choix</th></tr>');
    foreach($corporationChoices as $corporation){
        echo('<tr><td>' . $corporation['name'] . '</td>');
        echo('<td>' . $corporation['frequency'] . '</td');
        echo('<td>' .$corporation['total'] . '</td></tr>');
    }
?>
</tbody>