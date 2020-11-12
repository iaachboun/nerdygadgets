<!DOCTYPE html>
<?php
include __DIR__ . "/header.php";
?>
<header>
    <h1>
       Bestelpagina
    </h1>
</header>
<form>
    Voornaam: <input type="text" required><br><br>
    Tussenvoegsel: <input type="text"><br><br>
    Achternaam: <input type="text" required><br><br>
    Straatnaam: <input type="text" required><br><br>
    Huisnummer: <input type="number" required><br><br>
    Toevoeging: <input type="text"><br><br>
    Woonplaats: <input type="text" required><br><br>
    Telefoonnummer: <input type="text" required><br><br>
    <input type="submit" name="submit" value="Opslaan en naar de volgende stap">
</form>
<?php
include __DIR__ . "/footer.php";
?>
<?php
if(isset($_))


?>
