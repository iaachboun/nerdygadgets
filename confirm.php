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
        <div class="col-4">
            <br>
            <h2> Uw gegevens: </h2>
            <table>
                <tr><th>Uw voornaam</th>
                    <td>Test</td>
                </tr>
                <?php
                if(isset($_POST["tussenvoegsel"])){
                    print "<tr><th>Uw tussenvoegsel </th>
                    <td>Test</td></tr>";
                }?>
                <tr><th>Uw achternaam</th>
                    <td>Test</td>
                </tr>
                <tr><th>Uw postcode</th>
                    <td>Test</td>
                </tr>
                <tr><th>Uw huisnummer</th>
                    <td>Test</td>
                </tr>
                <?php
                if(isset($_POST["toevoeging"])){
                    print "<tr><th>Uw toevoeging </th>
                    <td>Test</td></tr>";
                }?>
                <tr><th>Uw woonplaats</th>
                    <td>Test</td>
                </tr>
                <tr><th>Uw e-mailadres</th>
                    <td>Test</td>
                </tr>


            </table>
        </div>
        <div class="col-6 cart">
            <br>
            <h2> Uw bestelling: </h2>
            <br>
            <?php
            if (isset($_SESSION["cart"])) {
                print '<table style="text-align: center"><tr>
           <th>Productnaam</th>
           <th>Aantal</th>
           <th>Prijs</th>
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
                    echo "<td style='text-align: left'>
                           
                      </td></tr>";
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
                echo "<tr><td></td><td></td><td></td><td><a href='cart.php'><input type=button name='bestellen' value='Terug naar het winkelmandje' class='btn btn-primary'></a></tr>";
                echo "<tr><td></td><td></td><td></td><td><a href='order_placed.php'><input type=button name='order_placed' value='Bestelling afronden en afrekenen' class='btn btn-primary'></a></tr>";


            } else {
                print 'Er zit niks in de winkelmand!';
            }
            ?>
        </div>



<?php
include __DIR__ . "/footer.php";
?>
<?php
//if (isset($_))
//    $query = "INSERT INTO";
//
//$Statement = mysqli_prepare($Connection, $query);
//mysqli_stmt_bind_param($Statement, "i", $productnummer);
//mysqli_stmt_execute($Statement);
//$R = mysqli_stmt_get_result($Statement);
//$R = mysqli_fetch_all($R, MYSQLI_ASSOC);

?>
