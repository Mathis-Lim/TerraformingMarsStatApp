<?php
    if(isset($creation)){
        echo('<i>L\'extension a bien été enregistrée</i>');
    }
?>
<h1>Liste des extensions</h1>
<ul>
    <?php
        foreach($extensionArray as $extension){
            echo('<li>' . $extension->getName() . '</li>');
        }
    ?>
</ul>
<p>
    <?php
        require File::build_path(array("View", "Extension","create.php"));