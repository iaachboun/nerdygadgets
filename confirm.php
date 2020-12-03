<!DOCTYPE html>
<?php
include __DIR__ . "/header.php";
include __DIR__ . "/connect.php";

//Variabelen:
$totaalPrijs = 0;
$teller = 0;
$subtotaal = 0;
$btwWaarde = 0;


//Session variabelen uit de post van bestelpagina
$_SESSION["voornaam"] = $_POST["voornaam"];
if (isset($_POST["tussenvoegsel"])) {
    $_SESSION["tussenvoegsel"] = $_POST["tussenvoegsel"];
}
$_SESSION["achternaam"] = $_POST["achternaam"];
$_SESSION["telefoonnummer"] = $_POST["telefoonnummer"];
$_SESSION["postcode"] = $_POST["postcode"];
$_SESSION["huisnummer"] = $_POST["huisnummer"];
if (isset($_POST["toevoeging"])) {
    $_SESSION["toevoeging"] = $_POST["toevoeging"];
}
$_SESSION["woonplaats"] = $_POST["woonplaats"];
$_SESSION["straatnaam"] = $_POST["straatnaam"];
$_SESSION["email"] = $_POST["email"];
?>


<div class="w3-row-padding">
    <div class="w3-half w3-container ">
        <div id="StockItemDescription">
            <h1> Uw gegevens: </h1>
            <br>
            <table>
                <tr>
                    <th>Voornaam:</th>
                    <td><?php print ($_SESSION["voornaam"]) ?></td>
                </tr>
                <?php
                if (isset($_POST["tussenvoegsel"])) {
                    print "<tr><th>Tussenvoegsel: </th>
                    <td>";
                    print ($_SESSION["tussenvoegsel"]);
                    print "</td></tr>";
                } ?>
                <tr>
                    <th>Achternaam:</th>
                    <td><?php print ($_SESSION["achternaam"]) ?></td>
                </tr>
                <tr>
                    <th>Postcode:</th>
                    <td><?php print ($_SESSION["postcode"]) ?></td>
                </tr>
                <tr>
                    <th>Huisnummer:</th>
                    <td><?php print ($_SESSION["huisnummer"]) ?></td>
                </tr>
                <?php
                if (isset($_POST["toevoeging"])) {
                    print "<tr><th>Toevoeging: </th>
                    <td>";
                    print ($_SESSION["toevoeging"]);
                    print "</td></tr>";
                } ?>
                <tr>
                    <th>Woonplaats:</th>
                    <td><?php print ($_SESSION["woonplaats"]) ?></td>
                </tr>
                <tr>
                    <th>Straatnaam:</th>
                    <td><?php print ($_SESSION["straatnaam"]) ?></td>
                </tr>
                <tr>
                    <th>E-mailadres:</th>
                    <td><?php print ($_SESSION["email"]) ?></td>
                </tr>
            </div>
    </div>
    </table>
    <br>
    <table>
        <h1>Betaling:</h1>
        <br>
        <form method="POST">
            <label for="betaalmethode">Kies een betaalmethode:</label>
            <select id="betaalmethode" name="betaalmethode">
                <option value="IDEAL">IDEAL</option>
            </select>
            <br>
            <p><strong>Let op:</strong> Op dit moment is alleen IDEAL beschikbaar.</p>
                <br>
                <label for="bank">Kies een bank:</label>
                <select id="bank" name="bank">
                    <option value="rabobank">Rabobank</option>
                    <option value="ing">ING</option>
                    <option value="abnamro">ABN AMRO</option>
                    <option value="sns">SNS</option>
                </select>
        </form>
    </table>

    <br>
    <table>
        <h1>Adresgegevens:</h1>
        <br>
        <h4>Afleveradres:</h4>
        <br>
        <form method="POST">
            <p> Is het ingevulde huisadres hetzelfde als het afleveradres?</p>
            <div>
            <input type="checkbox" id="ADRESJA" name="ADRESJA" > Ja!
            <input type="checkbox" id="ADRESNEE" name="ADRESNEE" onclick="myFunction()"> Nee!
    </table>
    <div id="text" style="display:none">
    <form method="POST">
        <h2>Aangepaste afleveradres:</h2>
        <br>
        <tr>
            <td style="width: 50%;"><label for="Straatnaam">Straatnaam:*</label><br /> <input id="straatnaam" name="straatnaam" required="" type="text"/></td>
            <td style="width: 50%;"><label for="Huisnummer">Huisnummer:*</label><br /> <input id="huisnummer" name="huisnummer" required="" type="number"/></td>
            <td style="width: 50%;"><label for="Postcode">Postcode:*</label><br /> <input id="postcode" name="postcode" required="" type="text"/></td>
            <td style="width: 50%;"><label for="Woonplaats">Woonplaats:*</label><br /> <input id="woonplaats" name="woonplaats" required="" type="text"/></td>
        </tr>
    </form>

    </div>
</div>
</div>

<script>
    function myFunction() {
    var checkBox = document.getElementById("ADRESNEE");
        var text = document.getElementById("text");
            if (checkBox.checked == true){
                text.style.display = "block";
            } else {
                text.style.display = "none";
            }
    }
</script>



<div class="w3-row">
    <div class="w3-half w3-container">
        <div class=shopping-cart">
            <div id="StockItemDescription">
            <h1> Uw bestelling:</h1>
                <br>
            <?php
            if (isset($_SESSION["cart"])) {
                print '<table style="text-align: center"><tr>
           <th>Product</th>
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

            //Hier beginnen de plaatjes query's
            //Nodige variabelen:
            $map = '';

            $query2 = "
                        SELECT ImagePath
                        FROM stockitemimages 
                        WHERE StockItemID = ?;";

            $Statement = mysqli_prepare($Connection, $query2);
            mysqli_stmt_bind_param($Statement, "i", $productnummer);
            mysqli_stmt_execute($Statement);
            $R2 = mysqli_stmt_get_result($Statement);
            $R2 = mysqli_fetch_all($R2, MYSQLI_ASSOC);



            if ($R2) {
                $Images = $R2;
                $map = 'StockItemIMG';

            }
            else{
                $query = "        SELECT SG.ImagePath, SG.StockGroupName
                        FROM stockgroups SG
                        JOIN stockitemstockgroups SISG ON SG.StockGroupID = SISG.StockGroupID
                        WHERE SISG.StockItemID = ?;";

                $Statement = mysqli_prepare($Connection, $query);
                mysqli_stmt_bind_param($Statement, "i", $productnummer);
                mysqli_stmt_execute($Statement);
                $R3 = mysqli_stmt_get_result($Statement);
                $R3 = mysqli_fetch_all($R3, MYSQLI_ASSOC);
                $Images = $R3;
                $map = 'StockGroupIMG';


            }
            print'<td>';
            ?>
                <div id="ImageFrame"
                     style="background-image: url('Public/<?php print $map ?>/<?php print $Images[0]['ImagePath']; ?>'); background-size: 300px; background-repeat: no-repeat; background-position: center;"></div>
                        </div>
                            <?php
                                        print '<td style="text-align: left">';
                                        print ($R[0]["StockItemName"]);
                                        print '</td>';
                                        print '<td>';
                                        print "$aantal";
                                        print '</td>';
                                        print '<td>';
                                        print '€';
                                        print round(($R[0]["SellPrice"]), 2) * $aantal;
                                        print '</td>';
                                        echo "<td style='text-align: left'>
                                               
                                          </td></tr>";
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
                                    echo "<tr><td></td><td></td><td></td><td><a href='order_placed.php?order_placed=TRUE'><input type=button name='order_placed' value='Bestelling afronden en afrekenen' class='btn-primary btn-lg'></a></tr>";
                                    echo "<tr><td></td><td></td><td></td><td><a href='cart.php'><input type=button name='bestellen' value='Annuleren!' class='btn-secondary btn-danger' onclick='return confirm(`Weet je het zeker?`)'></a></tr>";
}

        if (!isset($_SESSION["cart"])) {
            print 'Er zit niets in de winkelwagen!';
        }
            ?>
        </div>
        </div>
    </div>
</div>
        <?php
        include __DIR__ . "/footer.php";
        //if (isset($_))
        //    $query = "INSERT INTO";
        //
        //$Statement = mysqli_prepare($Connection, $query);
        //mysqli_stmt_bind_param($Statement, "i", $productnummer);
        //mysqli_stmt_execute($Statement);
        //$R = mysqli_stmt_get_result($Statement);
        //$R = mysqli_fetch_all($R, MYSQLI_ASSOC);

   ?>