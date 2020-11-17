<!DOCTYPE html>
<?php
include __DIR__ . "/header.php";
?>
<header>
    <h1>
       Overzicht bestelinformatie
    </h1>
</header>
<table>
    <tr>
        <th><h6>voornaam</h6></th>
        <th><h6>tussenvoegsel</h6></th>
        <th><h6>achternaam</h6></th>
    </tr>
    <tr>
        <td><p><?php print($_GET["voornaam"]); ?></p></td>
        <td><p><?php print($_GET["tussenvoegsel"]); ?></p></td>
        <td><p><?php print($_GET["achternaam"]); ?></p></td>
    </tr>
</table>
<table>
    <tr>
        <th><h6>straatnaam</h6></th>
        <th><h6>huisnummer</h6></th>
        <th><h6>toevoeging</h6></th>
        <th><h6>woonplaats</h6></th>
    </tr>
    <tr>
        <td><p><?php print($_GET["straatnaam"]); ?></p></td>
        <td><p><?php print($_GET["huisnummer"]); ?></p></td>
        <td><p><?php print($_GET["toevoeging"]); ?></p></td>
        <td><p><?php print($_GET["woonplaats"]); ?></p></td>
    </tr>
</table>
<table>
    <tr>
        <th><h6>telefoonnummer</h6></th>
    </tr>
    <tr>
        <td><p><?php print($_GET["telefoonnummer"]); ?></p></td>
    </tr>
</table>

</html>