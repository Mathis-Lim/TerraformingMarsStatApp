<form method="post" action="index.php?controller=game&action=created">
  <fieldset>
    <legend>Enregistrer une partie:</legend>
    <p>
        <label for="number_player">Nombre de joueurs: </label>
        <select id="number_player" name="number_player" required>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
    </p>
    <p>
        <label for="number_generation">Nombre de générations: </label>
        <input type="number" name="number_generation" id="number_generation" step="1" required/>
    </p>
    <p>
      <label for="extensions_used">Extensions utilisées: </label>
      <select multiple name="extensions_used[]" id="extensions_used" required>
        <?php
          foreach($extensionArray as $extension){
            echo('<option value="' .  $extension->getId() . '">' . $extension->getName() . '</option>');
          }
        ?>
      </select>
      <label for="map_id">Carte utilisée: </label>
      <select name="map_id" id="map_id" required>
        <?php
          foreach($mapArray as $map){
            echo('<option value="' . $map->getId() . '">' . $map->getName() . '</option>');
          }
        ?>
      </select>  
    </p>      
    <p>
      <input type="submit" value="Suivant"/>
    </p>
  </fieldset> 
</form>	


