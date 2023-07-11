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