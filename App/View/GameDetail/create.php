<form method="post" action="index.php?controller=GameDetail&action=gameDetailsSet">
  <fieldset>
    <legend>Enregistrer une partie:</legend>
    <input type='hidden' name='game_id' value='<?php echo($gameId); ?>'>
    <input type='hidden' name='player_number' value='<?php echo($nbPlayer); ?>'>
    <?php
        for ($i = 1; $i <= $nbPlayer; $i++) {
            echo('<h2>Joueur ' . $i . '</h2><p>');

            echo('<p><label for="player_' . $i. '">Nom: </label>');
            echo('<select id="player_' . $i . '" name="player_' . $i . '" required>');
            foreach($playerArray as $player){
                echo('<option value="' . $player->getId() . '">' . $player->getName() . '</option>');
            }
            echo('</select>');

            echo('<label for="chosen_corporation_' . $i . '">Corporation choisie: </label>');
            echo('<select id="chosen_corporation_' . $i . '" name="chosen_corporation_' . $i . '" required>');
            foreach($corporationArray as $corporation){
                echo('<option value="' . $corporation->getId() . '">' . $corporation->getName() . '</option>');
            }
            echo('</select>');

            echo('<label for="rejected_corporation_' . $i . '">Corporation rejetée: </label>');
            echo('<select id="rejected_corporation_' . $i . '" name="rejected_corporation_' . $i . '" required>');
            foreach($corporationArray as $corporation){
                echo('<option value="' . $corporation->getId() . '">' . $corporation->getName() . '</option>');
            }
            echo('</select></p>');

            echo('<p><label for="rank_' . $i. '">Position: </label>');
            echo('<input type="number" name="rank_' . $i . '" id="rank_' . $i . '" step="1" required/>');

            echo('<label for="tr_score_' . $i. '">Niveau de terraformation: </label>');
            echo('<input type="number" name="tr_score_' . $i . '" id="tr_score_' . $i . '" step="1" required/>');

            echo('<label for="board_score_' . $i. '">Points de plateau: </label>');
            echo('<input type="number" name="board_score_' . $i . '" id="board_score_' . $i . '" step="1" required/>');

            echo('<label for="card_score_' . $i. '">Points de cartes: </label>');
            echo('<input type="number" name="card_score_' . $i . '" id="card_score_' . $i . '" step="1" required/>');

            echo('<label for="goal_score_' . $i. '">Points d\'objectifs: </label>');
            echo('<input type="number" name="goal_score_' . $i . '" id="goal_score_' . $i . '" step="1" required/>');

            echo('<label for="award_score_' . $i. '">Points de récompenses: </label>');
            echo('<input type="number" name="award_score_' . $i . '" id="award_score_' . $i . '" step="1" required/></p></p>');
        }
    ?>
    <input type="submit" value="Suivant"/>

</fieldset> 
</form>	

