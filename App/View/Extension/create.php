<form method="get" action="index.php">
  <fieldset>
    <legend>Enregistrer une extension:</legend>
    <input type='hidden' name='controller' value='extension'>
    <input type='hidden' name='action' value='created'>
    <p>
        <label for="extension_name">Nom </label>:
        <input type="text" name="extension_name" id="extension_name" required/>
    <p>
      <input type="submit" value="Enregistrer"/>
    </p>
  </fieldset> 
</form>	