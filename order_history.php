<?php
include __DIR__ . "/header.php";
include __DIR__ . "/connect.php";
?>

    <html>
    <h1> Uw bestelhistorie</h1>
    </html>

<?php
if (isset($_SESSION[""]))


    ?>

    <?php
if (isset($_SESSION["cart"])) {
    print '<table style="text-align: left"><tr>
           <th>Afbeelding</th>
           <th>Productnaam</th>
           <th>Aantal</th>
           <th>Prijs</th>
           <th>Verwijderen</th>
           </tr>';
} ?>