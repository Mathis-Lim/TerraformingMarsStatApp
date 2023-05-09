<form method="get" action="index.php">
  <fieldset>
    <legend>Enregistrer un joueur:</legend>
    <input type='hidden' name='controller' value='player'>
    <input type='hidden' name='action' value='created'>
    <p>
        <label for="player_name">Nom </label>:
        <input type="text" name="player_name" id="player_name" required/>
    <p>
      <input type="submit" value="Enregistrer"/>
    </p>
  </fieldset> 
</form>	