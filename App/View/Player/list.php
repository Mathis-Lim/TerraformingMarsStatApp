<?php
    if(isset($creation)){
        echo('<i>Le joueur a bien été enregistré</i>');
    }
?>
<h1>Liste des joueurs</h1>
<ul>
    <?php
        foreach($playerArray as $player){
            echo('<li><a href = "index.php?controller=Player&action=read&player_id=' . $player->getId() . '">'
             . $player->getName() . '</a></li>');
            var_dump($player);
        }
    ?>
</ul>
<p>
    <?php
        require File::build_path(array("View", "Player","create.php"));