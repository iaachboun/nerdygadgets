<?php include __DIR__ . "/header.php";
include __DIR__ . "/connect.php";

?>

<div class="klantgegevens-section">
    <div class="container">
        <br>
        <h1>Uw gegevens</h1>

        <br>
        <br>
        <div class="row">
            <?php

            $queryOrders = "SELECT * FROM webshop_customers WHERE email = ?";
            $Statement = mysqli_prepare($Connection, $queryOrders);

            mysqli_stmt_bind_param($Statement, "s", $_SESSION['email']);

            mysqli_stmt_execute($Statement);
            $klantGegevens = mysqli_stmt_get_result($Statement);
            $klantGegevens = mysqli_fetch_all($klantGegevens, MYSQLI_ASSOC);


            ?>
            <form action="updateKlantGegevens.php" method="post">
                <div class="form-group row">
                    <label for="Voornaam" class="col-sm-2 col-form-label labelInput">Voornaam : </label>
                    <div class="col-sm-10">
                        <input style="border: 1px solid white; border-radius: 5px" type="text" class="form-control-plaintext klantGegevensInput" id="Voornaam"
                               value="<?php echo $klantGegevens[0]['firstname']  ?>" name="voornaam">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Tussenvoegsel" class="col-sm-2 labelInput">Tussenvoegsel :</label>
                    <div class="col-sm-10">
                        <input style="border: 1px solid white; border-radius: 5px" type="text" class="form-control-plaintext klantGegevensInput" id="Tussenvoegsel"
                               value="<?php echo $klantGegevens[0]['insertion'] ?>"  name="tussenvoegsel">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Achternaam" class="col-sm-2 col-form-label labelInput">Achternaam :</label>
                    <div class="col-sm-10">
                        <input style="border: 1px solid white; border-radius: 5px" type="text" class="form-control-plaintext klantGegevensInput" id="Achternaam"
                               value="<?php echo $klantGegevens[0]['lastname'] ?>" name="achternaam">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Straat" class="col-sm-2 labelInput">Straat :</label>
                    <div class="col-sm-10">
                        <input style="border: 1px solid white; border-radius: 5px" type="text" class="form-control-plaintext klantGegevensInput" id="Straat"
                               value="<?php echo $klantGegevens[0]['streetname'] ?>" name="straatnaam">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Huisnummer" class="col-sm-2 labelInput">Huisnummer :</label>
                    <div class="col-sm-10">
                        <input style="border: 1px solid white; border-radius: 5px" type="text" class="form-control-plaintext klantGegevensInput" id="Huisnummer"
                               value="<?php echo $klantGegevens[0]['housenumber'] ?>" name="huisnummer">
                    </div>
                </div>


                <div class="form-group row">
                    <label for="Toevoeging" class="col-sm-2 labelInput">Toevoeging :</label>
                    <div class="col-sm-10">
                        <input style="border: 1px solid white; border-radius: 5px" type="text" class="form-control-plaintext klantGegevensInput" id="Toevoeging"
                               value="<?php echo $klantGegevens[0]['addition']  ?>" name="toevoeging">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Stad" class="col-sm-2 labelInput">Stad :</label>
                    <div class="col-sm-10">
                        <input style="border: 1px solid white; border-radius: 5px" type="text" class="form-control-plaintext klantGegevensInput" id="Stad"
                               value="<?php echo $klantGegevens[0]['city'] ?>" name="woonplaats">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Telefoon" class="col-sm-2 labelInput">Telefoon :</label>
                    <div class="col-sm-10">
                        <input style="border: 1px solid white; border-radius: 5px" type="text" class="form-control-plaintext klantGegevensInput" id="Telefoon"
                               value="<?php echo $klantGegevens[0]['phone'] ?>" name="telefoonnummer">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Postcode" class="col-sm-2 labelInput">Postcode :</label>
                    <div class="col-sm-10">
                        <input style="border: 1px solid white; border-radius: 5px" type="text" class="form-control-plaintext klantGegevensInput" id="Postcode"
                               value="<?php echo $klantGegevens[0]['postal_code'] ?>" name="postcode">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Email" class="col-sm-2 labelInput">Email :</label>
                    <div class="col-sm-10">
                        <input style="border: 1px solid white; border-radius: 5px" type="text" class="form-control-plaintext klantGegevensInput" id="Email"
                               value="<?php echo $klantGegevens[0]['email'] ?>" name="email">
                    </div>
                </div>

                <input type="submit" name="submit" value="Sla je nieuwe gegevens op" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>

<?php
include __DIR__ . "/footer.php"; ?>
