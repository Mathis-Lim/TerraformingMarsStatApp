<form method="post" action="index.php?controller=gameDetail&action=goalsAwardsSet">
  <fieldset>
    <legend>Enregistrer les objectifs et les récompenses:</legend>

    <input type="hidden" id="game_id" name="game_id" value="<?php echo($gameId)?>">

        <?php
            for ($i = 1; $i < 4; $i++) {
                echo('<p><h2>Objectif n°' . $i . ': <h2>');
                echo('<label for="goal_' . $i. '">objectif: </label>');
                echo('<select id="goal_' . $i .'" name="goal_' . $i. '">');
                echo('<option value="NAF">Non financé</option>');
                foreach($goalArray as $goal){
                    echo('<option value="' . $goal->getId() . '">' . $goal->getName() . '</option>');
                }
                echo('</select>');
                echo('<label for="goal_player_' . $i. '">joueur: </label>');
                echo('<select id="goal_player_' . $i. '" name="goal_player_' . $i. '">');
                echo('<option value="NAF">Non financé</option>');
                foreach($playerArray as $player){
                    echo('<option value="' . $player->getId() . '">' . $player->getName() . '</option>');
                }
                echo('</select></p>');
            }

            for ($i = 1; $i < 4; $i++) {
                echo('<p><h2>Récompense n°' . $i . ': <h2>');
                echo('<label for="award_' . $i. '">récompense: </label>');
                echo('<select id="award_' . $i .'" name="award_' . $i. '">');
                echo('<option value="NAF">Non financée</option>');
                foreach($awardArray as $award){
                    echo('<option value="' . $award->getId() . '">' . $award->getName() . '</option>');
                }
                echo('</select>');
                echo('<label for="award_player_' . $i. '">joueur: </label>');
                echo('<select id="award_player_' . $i. '" name="award_player_' . $i. '">');
                echo('<option value="NAF">Non financée</option>');
                foreach($playerArray as $player){
                    echo('<option value="' . $player->getId() . '">' . $player->getName() . '</option>');
                }
                echo('</select></p>');
            }
        ?>
        <p>
            <input type="submit" value="Enregistrer"/>
        </p>
    </fieldset> 
</form>	
    