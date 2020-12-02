<?php require_once __DIR__ . "/header.php";
require_once __DIR__ . "/connect.php";

if (isset($_POST["voornaam"])) {
    $emailCheckQuery = "SELECT email FROM webshop_customers WHERE email = ?";

    $Statement = mysqli_prepare($Connection, $emailCheckQuery);
    mysqli_stmt_bind_param($Statement, "s", $_SESSION["email"]);
    mysqli_stmt_execute($Statement);
    $em = mysqli_stmt_get_result($Statement);
    $em = mysqli_fetch_all($em, MYSQLI_ASSOC);

    if (isset($em[0]['email'])) {
        $html = '<div class="container">
                    <div class="row">
                        <div class="col-6" style="margin: 0 auto">
                            
                            <p class="inlogStatus">Email wordt al gebruikt! <a href="registerAccount.php?newAcc=TRUE"><button class="btn btn-primary">Ga terug</button></a></p>
                        </div>
                    </div>
                </div>';
        echo $html;
    } else {
        $query = "INSERT INTO `webshop_customers` (`firstname`, `insertion`, `lastname`, `streetname`, `housenumber`, `addition`, `city`, `phone`, `postal_code`, `email`, `password`) VALUES (?, ?, ?, ?,?,?,?,?, ?,?,?);";
        $Statement = mysqli_prepare($Connection, $query);
        mysqli_stmt_bind_param($Statement, "ssssississs", $_POST["voornaam"], $_POST["tussenvoegsel"], $_POST["achternaam"], $_POST["straatnaam"], $_POST["huisnummer"], $_POST["toevoeging"], $_POST["woonplaats"], $_POST["telefoonnummer"], $_POST["postcode"], $_POST["email"], $_POST["password"]);
        mysqli_stmt_execute($Statement);
        $html = '<p class="inlogStatus">Je account is aangemaakt! <a href="index.php"><button class="btn btn-primary">Ga Terug</button></a></p>';
        echo $html;
    }


}

if (isset($_GET['newAcc'])) {
    if ($_GET['newAcc'] == TRUE) {
        $html = '<div class="container">
                    <div class="row">
                        <form class="form-group" method="post" action="registerAccount.php">
                            <table style="height: 100%; width: 100%;">
                                <tbody>
                                    <div class="col-12">
                                        <tr>
                                            <td><label for="voornaam">Voornaam:</label><br /> <input id="voornaam" name="voornaam" required="" type="text"/></td>
                                            <td><label for="postcode">Postcode:</label><br /> <input id="postcode" maxlength="7" name="postcode" required="" type="text"/></td>
                                        </tr>
                                        <tr>
                                            <td><label for="tussenvoegsel">Tussenvoegsel:</label><br /> <input id="tussenvoegsel" name="tussenvoegsel" type="text"/><br>
                                                <label for="achternaam">Achternaam:</label><br /> <input id="achternaam" name="achternaam" required="" type="text"/></td>
                                            <td><label for="huisnummer">Huisnummer:</label><br /> <input id="huisnummer" name="huisnummer" required="" type="number"/><br />
                                                <label for="toevoeging">Toevoeging:</label><br /> <input id="toevoeging" name="toevoeging" type="text"/></td>
                                        </tr>
                                        <tr>
                                            <td><label for="telefoonnummer">Telefoonnummer:</label><br /> <input id="telefoonnummer" name="telefoonnummer" required="" type="tel"/></td>
                                            <td><label for="woonplaats">Woonplaats:</label><br /> <input id="woonplaats" name="woonplaats" required="" type="text"/></td>
                                        </tr>
                                        <tr>
                                            <td><label for="straatnaam">Straatnaam:</label><br /> <input id="straatnaam" name="straatnaam" required="" type="text"/></td>
                                            <td>    <label for="email">E-mailadres:</label><br>
                                                <input type="email" id="email" name="email" required ><br></td>
                                                <td>    <label for="password">Password:</label><br>
                                                <input type="password" id="password" name="password" required ><br></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <button type="submit" name="opslaan" class="btn btn-primary">Registreer</button>
                                            </td>
                
                                        </tr>
                                    </div>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>';
        echo $html;
    }
}

?>


<?php
include __DIR__ . "/footer.php";
?>