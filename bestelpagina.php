<!DOCTYPE html>
<?php
include __DIR__ . "/header.php";
?>
<header>
    <h1>
       Bestelpagina
    </h1>
</header>
<form method="get" action="overzicht-bestelling.php">
    Voornaam: <input type="text" name="voornaam" required><br><br>
    Tussenvoegsel: <input type="text" name="tussenvoegsel" ><br><br>
    Achternaam: <input type="text" name="achternaam" required><br><br>
    Straatnaam: <input type="text" name="straatnaam" required><br><br>
    Huisnummer: <input type="number" name="huisnummer" required><br><br>
    Toevoeging: <input type="text" name="toevoeging" maxlength="3" ><br><br>
    Woonplaats: <input type="text" name="woonplaats" required><br><br>
    Telefoonnummer: <input type="text" name="telefoonnummer" maxlength="10" required><br><br>
    <input type="submit" name="submit" value="Opslaan en naar de volgende stap">
</form>
<?php
include __DIR__ . "/footer.php";
?>
<?php
if(isset($_))


?>
