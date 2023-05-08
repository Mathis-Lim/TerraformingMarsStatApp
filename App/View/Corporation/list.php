<h1>Liste des corporations</h1>
<ul>
    <?php
        foreach($corporationArray as $corporation){
            echo('<li>' . $corporation->getName() . '</li>');
        }
    ?>
</ul>