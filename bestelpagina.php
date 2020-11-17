<!DOCTYPE html>
<link rel="stylesheet" href="style.css">
<?php
include __DIR__ . "/header.php";
?>

<div class="container">
    <div class="row">
        <form >
            <div class="form-group">
                <label for="Voornaam">Voornaam:</label>
                <input type="text" class="form-control" id="Voornaam" aria-describedby="emailHelp"
                       placeholder="Enter voornaam">
            </div>
            <div class="form-group">
                <label for="Tussenvoegsel">Tussenvoegsel:</label>
                <input type="text" class="form-control" id="Tussenvoegsel" aria-describedby="emailHelp"
                       placeholder="Enter tussenvoegsel">
            </div>
            <div class="form-group">
                <label for="Achternaam">Achternaam:</label>
                <input type="text" class="form-control" id="Achternaam" aria-describedby="emailHelp"
                       placeholder="Enter achternaam">
            </div>
            <div class="form-group">
                <label for="Straatnaam">Straatnaam:</label>
                <input type="text" class="form-control" id="Straatnaam" aria-describedby="emailHelp"
                       placeholder="Enter straatnaam">
            </div>
            <div class="form-group">
                <label for="Huisnummer">Huisnummer:</label>
                <input type="number" class="form-control" id="Huisnummer" aria-describedby="emailHelp"
                       placeholder="Enter huisnummer">
            </div>
            <div class="form-group">
                <label for="Toevoeging">Toevoeging:</label>
                <input type="text" class="form-control" id="Toevoeging" aria-describedby="emailHelp"
                       placeholder="Enter toevoeging">
            </div>
            <div class="form-group">
                <label for="Woonplaats">Woonplaats:</label>
                <input type="text" class="form-control" id="Woonplaats" aria-describedby="emailHelp"
                       placeholder="Enter woonplaats">
            </div>
            <div class="form-group">
                <label for="Telefoonnummer">Telefoonnummer:</label>
                <input type="text" class="form-control" id="Telefoonnummer" aria-describedby="emailHelp"
                       placeholder="Enter telefoonnummer">
            </div>

            <button type="submit" class="btn btn-primary">Opslaan en naar de volgende stap</button>
        </form>
    </div>
</div>

<?php
include __DIR__ . "/footer.php";
?>
<?php
if (isset($_))


?>
