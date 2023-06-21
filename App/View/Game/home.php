<?php
    if(isset($creation)){
        echo('<i>La partie a bien été enregistrée</i><br><br>');
    }
?>
<h1>Accueil</h1>

<b><a href = "index.php?controller=Game&action=create">Enregistrer une partie</a></b>

<h2>Dernière partie: </h2>
<ul>
<?php
    echo('<li>Gagnant: ' . $winner . '</li>');
    echo('<li>Nombre de joueurs: ' . $nbPlayers .'</li>');
    echo('<li>Nombre de générations:' . $nbGen . '</li>');
    echo('<li>Carte utilisée: ' . $mapUsed . '</li>');
?>
</ul>








