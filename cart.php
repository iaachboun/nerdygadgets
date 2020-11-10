<?php
include __DIR__ . "/header.php";
$Connection = mysqli_connect("localhost", "root", "", "nerdygadgets");
mysqli_set_charset($Connection, 'latin1');

// Opzet winkelwage word als volgt:
// Ilias maakt een array in de session met de volgende opzet:
// $winkelwagen = array(42 => 1, 33 => 2)
// De key is het productnummer en de value is het aantal.



if(isset($_SESSION["cart"])) {
    print '<table><tr>
           <th>Verwijder product</th>
           <th>Productnaam</th>
           <th>Aantal</th>
           <th>Prijs</th>
           </tr>';

    foreach ($_SESSION["cart"] as $productnummer => $aantal) {
        print '<tr><th><input type="button" name="verwijderen" value="🗑️"></th>';

        $queryArtikelnaam = "SELECT StockItemName
                     FROM stockitems
                     WHERE StockItemID = $productnummer";

        $Statement = mysqli_prepare($Connection, $queryArtikelnaam);
        mysqli_stmt_bind_param($Statement, "s", $artikelnaam);
        mysqli_stmt_execute($Statement);
        $R = mysqli_stmt_get_result($Statement);
        $R = mysqli_fetch_all($R, MYSQLI_ASSOC);

        print '<th>';
        print "$R";
        print '</th></tr>';


    }
}
else{
    print 'Er zit niks in de winkelmand!';
}


