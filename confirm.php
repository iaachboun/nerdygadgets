<!DOCTYPE html>
<?php
include __DIR__ . "/header.php";
include __DIR__ . "/connect.php";

//Variabelen:
$totaalPrijs = 0;
$teller = 0;
$subtotaal = 0;
$btwWaarde = 0;

?>
<div class="container" >
    <div class="row">
        <div class="col-6 cart">

            <?php
            if (isset($_SESSION["cart"])) {
                print '<table style="text-align: center"><tr>
           <th>Productnaam</th>
           <th>Aantal</th>
           <th>Prijs</th>
           <th></th>
           </tr>';


                foreach ($_SESSION["cart"] as $productnummer => $aantal) {
                    $teller++;

                    $query = "SELECT StockItemName, TaxRate, RecommendedRetailPrice, (RecommendedRetailPrice*(1+(TaxRate/100))) AS SellPrice
                     FROM StockItems
                     WHERE StockItemID = ?";

                    $Statement = mysqli_prepare($Connection, $query);
                    mysqli_stmt_bind_param($Statement, "i", $productnummer);
                    mysqli_stmt_execute($Statement);
                    $R = mysqli_stmt_get_result($Statement);
                    $R = mysqli_fetch_all($R, MYSQLI_ASSOC);

                    print '<td style="text-align: left">';
                    print ($R[0]["StockItemName"]);
                    print '</td>';
                    print '<td>';
                    print "$aantal";
                    print '</td>';
                    print '<td>';
                    print round(($R[0]["SellPrice"]), 2) * $aantal;
                    print '</td>';
                    echo "<td style='text-align: left'><form method='post' action='cart.php'>
                            <button onclick='return confirm(`Weet je het zeker dat je dit product wilt verijwijderen?`)' type='submit' name='verwijder" . $productnummer . "' class='btn btn-danger actionBtn'><i class='far fa-trash-alt'></i></button>
                      </form></td></tr>";
                    if (isset($_POST["verwijder$productnummer"])) {
                        unset($_SESSION["cart"][$productnummer]);
                    }

                    $totaalPrijs = $totaalPrijs + (($R[0]["SellPrice"]) * $aantal);
                    $subtotaal = $subtotaal + ($R[0]["RecommendedRetailPrice"]);
                    $btwWaarde = ($R[0]["TaxRate"]) / 100 * $totaalPrijs;
                }
                $subtotalen = '';

                $subtotalen .= "<tr><td></td><td></td><td></td><td><p class='subtotalen'>Subtotaal: €" . round(($subtotaal), 2) . "</p><br>";
                $subtotalen .= "<p class='subtotalen'>BTW: €" . round(($btwWaarde), 2) . "</p>";
                $subtotalen .= "<p class='subtotalen'>Totaalprijs: €" . round(($totaalPrijs), 2) . "</p></td></tr>";

                print $subtotalen;
                print'<td>';
                print 'De verzendkosten zijn al in de prijs opgenomen!';
                print '</td>';

                echo "<tr><td></td><td></td><td></td><td><a href='bestelpagina.php'><input type=button name='bestellen' value='Bestelling afronden' class='btn btn-primary'></a></tr>";


            } else {
                print 'Er zit niks in de winkelmand!';
            }
            ?>
        </div>

<div class="container">
    <div class="row">
        <form>
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

            <button type="submit" class="btn btn-primary">Opslaan</button>
        </form>
    </div>
</div>

<?php
include __DIR__ . "/footer.php";
?>
<?php
if (isset($_))


?>
