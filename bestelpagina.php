<!DOCTYPE html>
<link rel="stylesheet" href="style.css">
<?php
include __DIR__ . "/header.php";
?>

<form method="post" action="confirm.php">
    <label for="voornaam">Voornaam:</label><br>
    <input type="text" class="form-group id="voornaam" name="voornaam" required ><br>
    <label for="tussenvoegsel">Tussenvoegsel:</label><br>
    <input type="text" id="tussenvoegsel" name="tussenvoegsel"><br>
    <label for="achternaam">Achternaam:</label><br>
    <input type="text" id="achternaam" name="achternaam" required><br>
    <label for="straatnaam">Straatnaam:</label><br>
    <input type="text" id="straatnaam" name="straatnaam" required><br>
    <label for="postcode">Postcode:</label><br>
    <input type="text" id="postcode" name="postcode" required maxlength="7"><br>
    <label for="huisnummer">Huisnummer:</label><br>
    <input type="number" id="huisnummer" name="huisnummer" required><br>
    <label for="toevoeging">Toevoeging:</label><br>
    <input type="text" id="toevoeging" name="toevoeging"><br>
    <label for="woonplaats">Woonplaats:</label><br>
    <input type="text" id="woonplaats" name="woonplaats" required><br>
    <label for="telefoonnummer">Telefoonnummer:</label><br>
    <input type="number" id="telefoonnummer" name="telefoonnummer" required min="9" max="10"><br>
    <label for="email">E-mailadres:</label><br>
    <input type="email" id="email" name="email" required><br>

<button> <input type="submit" name="opslaan" class="btn btn-primary"> Opslaan en naar de volgende stap</button>
</form>


        </form>

        <form method="post" action="cancel.php"> <button type="submit" name="cancel" class="btn btn-secondary">Afbreken!</button></form>

    </div>
</div>


<?php
include __DIR__ . "/footer.php";

?>