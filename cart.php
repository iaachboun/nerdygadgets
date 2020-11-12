<?php
include __DIR__ . "/header.php";
include __DIR__ . "/connect.php";


// Opzet winkelwage word als volgt:
// Ilias maakt een array in de session met de volgende opzet:
// $winkelwagen = array(42 => 1, 33 => 2)
// De key is het productnummer en de value is het aantal.


//TIJDELIJKE VARIABELE VOOR ITEMS IN DE MAND!!!
//$_SESSION["cart"] = array(1 => 1, 2 => 2, 3 => 3);



//Variabelen:
$totaalPrijs = 0;
$teller = 0;

$subtotaal = 0;
$btwWaarde = 0;

if(isset($_SESSION["cart"])) {


    print '<table><tr>
           <th>Verwijder product</th>
           <th>Productnaam</th>
           <th>Aantal</th>
           <th>Prijs</th>
           </tr>';



    foreach ($_SESSION["cart"] as $productnummer => $aantal) {
        $teller ++;

        print "<tr><th><form method='post' action='cart.php'><input type='submit' name='";
        print "verwijder$productnummer";
        print "' value='🗑️'></form></th>";

        if (isset($_POST["verwijder$productnummer"])){
            unset($_SESSION["cart"][$productnummer]);
        }

        $query = "SELECT StockItemName, TaxRate, RecommendedRetailPrice, (RecommendedRetailPrice*(1+(TaxRate/100))) AS SellPrice
                     FROM StockItems
                     WHERE StockItemID = ?";

        $Statement = mysqli_prepare($Connection, $query);
        mysqli_stmt_bind_param($Statement, "i", $productnummer);
        mysqli_stmt_execute($Statement);
        $R = mysqli_stmt_get_result($Statement);
        $R = mysqli_fetch_all($R, MYSQLI_ASSOC);

        print '<th>';
        print ($R[0]["StockItemName"]);
        print '</th>';
        print '<th>';
        print "$aantal";
        print '</th>';
        print '<th>';
        print round(($R[0]["SellPrice"]),2) * $aantal;
        print '</th></tr>';

        $totaalPrijs = $totaalPrijs + (($R[0]["SellPrice"]) * $aantal);
        $subtotaal = $subtotaal + ($R[0]["RecommendedRetailPrice"]);
        $btwWaarde = ($R[0]["TaxRate"])/100 * $totaalPrijs;
    }
    print '<th>';
    print "Subtotaal: $" . round(($subtotaal),2);
    print '</th></tr>';
    print '<th>';
    print "BTW: $" . round(($btwWaarde),2);
    print '</th></tr>';
    print '<th>';
    print "Totaalprijs: $" . round(($totaalPrijs),2);
    print '</th></tr>';
}
else{
    print 'Er zit niks in de winkelmand!';
}
?>
<html>
<input type=button name="bestellen" onClick="location.href='bestelpagina.php'" value="Bestellen">
</html>
