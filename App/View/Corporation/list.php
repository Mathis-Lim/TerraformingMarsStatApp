<?php
    if(isset($creation)){
        echo('<i>La corporation a bien été enregistrée</i>');
    }
?>
<h1>Liste des corporations</h1>
<ul>
    <?php
        foreach($corporationArray as $corporation){
            echo('<li>' . $corporation->getName() . '</li>');
        }
    ?>
</ul>
<p>
    <?php
        require File::build_path(array("View", "Corporation","create.php"));