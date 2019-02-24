<?php
$title = 'Options';
include_once("navigation.php");
?>
<main>
  <section>
    <h1>Colour Scheme</h1>
    <p>Select from a preset list of colours or create your own</p>
    <select name="colours">
      <option value="light" selected>Light</option>
      <option value="dark">Dark</option>
      <option value="red-green">Red-Green Safe</option>
    </select>
  </section>
  <section>
    <h1>Fonts</h1>
    <div class="fields">
      <div class="field">
        <label for="font-size">Font Size</label>
        <input type="number" min="10" max="30" name="font-size" value="16" id="font-size"/>
      </div>
    </div>
  </section>
  <section>
    <h1>Mining</h1>
    <div class="fields">
      <div class="field">
        <input type="checkbox" name="mine" value="mine" id="mine"/>
        <span class="checkmark"></span>
        <label for="mine">Check this box if you wish to enable mining. This allows us to generate revenue without advertisements.</label>
      </div>
    </div>
  </section>
</main>
<?php include_once("footer.php"); ?>
