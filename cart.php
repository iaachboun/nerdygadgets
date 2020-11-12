<?php
include __DIR__ . "/header.php";
$Connection = mysqli_connect("localhost", "ilias", "12345", "nerdygadgets");
mysqli_set_charset($Connection, 'latin1');

// Opzet winkelwage word als volgt:
// Ilias maakt een array in de session met de volgende opzet:
// $winkelwagen = array(42 => 1, 33 => 2)
// De key is het productnummer en de value is het aantal.


//TIJDELIJKE VARIABELE VOOR ITEMS IN DE MAND!!!
//$_SESSION["cart"] = array(1 => 1, 2 => 2, 3 => 3);


//Variabelen:
$totaalPrijs = 0;
$teller = 0;


if(isset($_SESSION["cart"])) {


    print '<table><tr>
           <th>Verwijder product</th>
           <th>Productnaam</th>
           <th>Aantal</th>
           <th>Prijs</th>
           </tr>';



    foreach ($_SESSION["cart"] as $productnummer => $aantal) {
        $teller ++;

        print '<tr><th><input type="submit" name="verwijderen" value="🗑️" formmethod="post"></th>';
        if (isset($_POST["verwijderen"])){
            print "test";
        }

        $query = "SELECT StockItemName, (RecommendedRetailPrice*(1+(TaxRate/100))) AS SellPrice
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

        $totaalPrijs = $totaalPrijs + round(($R[0]["SellPrice"]),2) * $aantal;

    }
    print $totaalPrijs;

}
else{
    print 'Er zit niks in de winkelmand!';
}
