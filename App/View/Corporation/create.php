
<form method="get" action="index.php">
  <fieldset>
    <legend>Enregistrer une corporation:</legend>
    <input type='hidden' name='action' value='created'>
    <p>
        <label for = "corporation_name">Nom </label>:
        <input type = "text" name = "name" id = "corporation_name" required/>
    <p>
      <input type="submit" value="Enregistrer"/>
    </p>
  </fieldset> 
</form>	