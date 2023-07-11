<h1>Détail de la partie n° <?php echo($gameId); ?></h1>
<?php
    

    foreach($playerDetails as $playerDetail){
        echo('<h2>' . $playerDetail['rank'] . ': ' . $playerDetail['player'] . '</h2>');

        echo('<h3>Corporations</h3><ul>');
        echo('<li>Choisie: ' . $playerDetail['chosen_corp'] . '</li>');
        echo('<li>Rejetée: ' . $playerDetail['rejected_corp'] . '</li></ul>');
        echo('<h3>Score</h3><table><tr><th>Type points</th><th>Score</th><th>Pourcentage</th></tr>');
        foreach($playerDetail['score'] as $score){
            echo('<tr><td>' . $score['description'] . '</td><td>' . $score['score'] . '</td><td>' . 
                $score['proportion'] . '%</td></tr>');
        }
        echo('</table>');
    }