<?php echo('<h2>' . $corporation->getName() . '</h2>'); ?>
<ul>
    <?php
        echo('<li>' .$nbPlayed . ' parties jouées </li>');
        echo('<li>' . $avgGameTime . ' générations par parties en moyenne </li>');
        echo('<li>' .$nbVictories . ' parties gagnées </li>');
        echo('<li>' . round($freqVictory * 100, 2) . '% de parties gagnées </li>');
    ?>
</ul>      