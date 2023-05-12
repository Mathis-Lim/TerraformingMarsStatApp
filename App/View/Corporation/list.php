<?php
    if(isset($creation)){
        echo('<i>La corporation a bien été enregistrée</i>');
    }
?>
<h1>Liste des corporations</h1>
<ul>
    <?php
        foreach($corporationArray as $corporation){
            echo('<li><a href = "index.php?controller=Corporation&action=read&corporation_id=' . $corporation->getId() . '">'
             . $corporation->getName() . '</a></li>');
        }
    ?>
</ul>
<p>
    <?php
        require File::build_path(array("View", "Corporation","create.php"));