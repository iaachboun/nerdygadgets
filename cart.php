<?php
include __DIR__ . "/header.php";
include __DIR__ . "/connect.php";


// Opzet winkelwagen word als volgt:
// Ilias maakt een array in de session met de volgende opzet:
// $winkelwagen = array(42 => 1, 33 => 2)
// De key is het productnummer en de value is het aantal.



//Variabelen:
$totaalPrijs = 0;
$teller = 0;

$subtotaal = 0;
$btwWaarde = 0;
?>
<div class="container">
    <div class="row">
        <div class="col-6 cart">

            <?php
            if (isset($_SESSION["cart"])) {
                print '<table style="text-align: center"><tr>
           <th>Productnaam</th>
           <th>Aantal</th>
           <th>-1</th>
           <th>+1</th>
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
                    echo "<form method='post' action='cart.php'>
                            <button type='submit' class='btn btn-info' name='min" . $productnummer . "' '></button>
                      </form>";
                    if (isset($_POST["min$productnummer"]) AND $_SESSION["cart"][$productnummer] > 0){
                        $_SESSION["cart"][$productnummer] -= 1;
                        if ($_SESSION["cart"][$productnummer] == 0){
                            unset($_SESSION["cart"][$productnummer]);
                        }
                    }
                    print '</td>';
                    print '<td>';
                    echo "<form method='post' action='cart.php'>
                            <button type='submit' value='test' class='btn btn-info' name='plus" . $productnummer . "' '></button>
                      </form>";
                    if (isset($_POST["plus$productnummer"]) AND $_SESSION["cart"][$productnummer] > 0){
                        $_SESSION["cart"][$productnummer] += 1;
                        if ($_SESSION["cart"][$productnummer] == 0){
                            unset($_SESSION["cart"][$productnummer]);
                        }
                    }
                    print '</td>';
                    print '<td>';
                    print '€';
                    print round(($R[0]["SellPrice"]), 2) * $aantal;
                    print '</td>';
                    echo "<td style='text-align: left'><form method='post' action='cart.php'>
                            <button onclick='return confirm(`Weet je het zeker dat je dit product wilt verijwijderen?`)' type='submit' name='verwijder" . $productnummer . "' class='btn btn-danger actionBtn'><i class='far fa-trash-alt'></i></button>
                      </form></td></tr>";
                    if (isset($_POST["verwijder$productnummer"])) {
                        unset($_SESSION["cart"][$productnummer]);
                    }

                    $totaalPrijs = $totaalPrijs + (($R[0]["SellPrice"]) * $aantal);
                    $subtotaal = $subtotaal + ($R[0]["RecommendedRetailPrice"] * $aantal);
                    $btwWaarde = ($R[0]["TaxRate"]) / 100 * $subtotaal;
                }
                $subtotalen = '';

                $subtotalen .= "<tr><td></td><td></td><td></td><td><p class='subtotalen'>Subtotaal: €" . round(($subtotaal), 2) . "</p><br>";
                $subtotalen .= "<p class='subtotalen'>BTW: €" . round(($btwWaarde), 2) . "</p>";
                $subtotalen .= "<p class='subtotalen'>Totaalprijs: €" . round(($totaalPrijs), 2) . "</p></td></tr>";

                print $subtotalen;
                print'<td>';
                print 'De verzendkosten zijn al in de prijs opgenomen!';
                print '</td>';

                echo "<tr><td></td><td></td><td></td><td><a href='bestelpagina.php'><input type=button name='bestellen' value='Bestellen' class='btn btn-primary'></a></tr>";


            } else {
                print 'Er zit niks in de winkelmand!';
            }
            ?>
        </div>
    </div>
</div>

