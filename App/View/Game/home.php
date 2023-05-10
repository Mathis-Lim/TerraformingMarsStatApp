<?php
    if($creation == true){
        echo('<i>La partie a bien été enregistrée</i>');
    }
    require File::build_path(array("View", "Game","create.php"));