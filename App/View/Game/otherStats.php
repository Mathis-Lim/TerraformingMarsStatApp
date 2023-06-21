<h1>Autres statistiques</h1>
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