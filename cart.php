<?php
include __DIR__ . "/header.php";
// Opzet winkelwage word als volgt:
// Ilias maakt een array in de session met de volgende opzet:
// $winkelwagen = array(42 => 1, 33 => 2)
// De key is het productnummer en de value is het aantal.

//TIJDELIJKE (TEST) ARRAY!!!:
$_SESSION["cart"] = array(42=>1,233=>2);

if(isset($_SESSION["cart"])) {
    print '<table><tr>
           <th>Verwijder product</th>
           <th>Productnaam</th>
           <th>Aantal</th>
           <th>Prijs</th>
           </tr>';

    foreach ($_SESSION["cart"] as $productnummer => $aantal) {
        print '<tr><th><input type="button"></th></tr>';
    }
}
else{
    print 'Er zit niks in de winkelmand!';
}