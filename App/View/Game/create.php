<form method="post" action="index.php">
  <fieldset>
    <legend>Enregistrer une partie:</legend>
    <input type='hidden' name='controller' value='game'>
    <input type='hidden' name='action' value='created'>
    <p>
        <label for="number_player">Nombre de joueurs: </label>
        <select id="number_player" name="number_player">
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
      <select multiple name="extensions_used[]" id="extensions_used">
        <?php
          foreach($extensionArray as $extension){
            echo('<option value="' .  $extension->getId() . '">' . $extension->getName() . '</option>');
          }
         ?>
        </select>  
    <p>
      <input type="submit" value="Suivant"/>
    </p>
  </fieldset> 
</form>	


