<?php
include __DIR__ . "/header.php";
include __DIR__ . "/connect.php";

if (isset($_GET['logout'])) {
    if ($_GET['logout'] == TRUE) {
        //Session variabelen uit de post van bestelpagina
        unset($_SESSION["customerID"]);
        unset($_SESSION["voornaam"]);
        unset($_SESSION["tussenvoegsel"]);
        unset($_SESSION["achternaam"]);
        unset($_SESSION["telefoonnummer"]);
        unset($_SESSION["postcode"]);
        unset($_SESSION["huisnummer"]);
        unset($_SESSION["toevoeging"]);
        unset($_SESSION["woonplaats"]);
        unset($_SESSION["straatnaam"]);
        unset($_SESSION["email"]);

        $_SESSION['login'] = FALSE;

        $html = '<div class="container">
                <div class="row">
                    <div class="col-6" style="margin: 0 auto">
                        <p class="inlogStatus">Je bent uitgelogd <a href="index.php"><button class="btn btn-primary">Ga Terug</button></a></p>
                    </div>
                </div>
            </div>';
        echo $html;
    }
}
// Submit van login formulier
if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    $query0 = "SELECT password FROM webshop_customers WHERE email = ?";

    $Statement0 = mysqli_prepare($Connection, $query0);
    mysqli_stmt_bind_param($Statement0, "s", $_POST['email']);
    mysqli_stmt_execute($Statement0);
    $R0 = mysqli_stmt_get_result($Statement0);
    $R0 = mysqli_fetch_all($R0, MYSQLI_ASSOC);

    if(password_verify($_POST['password'], $R0[0]['password'])) {
        $query = "SELECT * FROM webshop_customers WHERE email = ?";

        $Statement = mysqli_prepare($Connection, $query);
        mysqli_stmt_bind_param($Statement, "s", $_POST['email']);
        mysqli_stmt_execute($Statement);
        $R = mysqli_stmt_get_result($Statement);
        $R = mysqli_fetch_all($R, MYSQLI_ASSOC);
    }

    else {
        $html = '<div class="container"> <p>Verkeerde inlog gegevens</p>';
        $html .= ' <a href="login.php"><button class="btn btn-primary">Ga terug</button></a></div>';

    }

    if (isset($R[0]["customerID"])) {
        //Test om ingelogde mail op te slaan in session
        $_SESSION["email_login"] = $_POST['email'];

        //Session variabelen uit de post van bestelpagina
        $_SESSION["customerID"] = $R[0]["customerID"];
        $_SESSION["voornaam"] = $R[0]["firstname"];
        if (isset($R[0]["insertion"])) {
            $_SESSION["tussenvoegsel"] = $R[0]["insertion"];
        }
        $_SESSION["achternaam"] = $R[0]["lastname"];
        $_SESSION["telefoonnummer"] = $R[0]["phone"];
        $_SESSION["postcode"] = $R[0]["postal_code"];
        $_SESSION["huisnummer"] = $R[0]["housenumber"];
        if (isset($R[0]["addition"])) {
            $_SESSION["toevoeging"] = $R[0]["addition"];
        }
        $_SESSION["woonplaats"] = $R[0]["city"];
        $_SESSION["straatnaam"] = $R[0]["streetname"];
        $_SESSION["email"] = $R[0]["email"];

        $_SESSION['login'] = TRUE;
        $html = '<div class="container">
                    <div class="row">
                        <div class="col-6" style="margin: 0 auto">
                            <p class="inlogStatus">Je bent ingelogd <a href="index.php"><button class="btn btn-primary">Ga Terug</button></a></p>
                        </div>
                    </div>
                </div>';
    } else {
        $html = '<div class="container"> <p>Verkeerde inlog gegevens</p>';
        $html .= ' <a href="login.php"><button class="btn btn-primary">Ga terug</button></a></div>';
    }

    echo $html;

} else {
    echo showLoginForm();
}

function showLoginForm()
{
    $html = '';?>
    <div class="container">
        <script src="https://www.google.com/recaptcha/api.js?render=6Lc1ffcZAAAAACvSDVgmKbgKBUapYoWdlHvhwScK"></script>

        <div class="row">
            <div class="col-3" style="margin: 0 auto; top: 150px">
                <form method="post" action="login.php">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input name="email" type="email" class="form-control" id="exampleInputEmail1"
                               aria-describedby="emailHelp" placeholder="Enter email" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input name="password" type="password" class="form-control" id="exampleInputPassword1"
                               placeholder="Password" required>
                    </div>

                    <button type="submit" class="btn btn-primary" name="submit" data-sitekey="reCAPTCHA_site_key"
                            data-callback='onSubmit'
                            data-action='submit'>Submit</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                    <p>Heb je nog geen account?</p>
                    <a href="registerAccount.php?newAcc=TRUE"><button class="btn btn-success">Maak een account aan</button></a>
            </div>
        </div>
    </div>
    <?php
    return $html;
}
?>


<script src="https://www.google.com/recaptcha/api.js"></script>


<script>
    function onSubmit(token) {
        document.getElementById("demo-form").submit();
    }

    function onClick(e) {
        e.preventDefault();
        grecaptcha.ready(function() {
            grecaptcha.execute('reCAPTCHA_site_key', {action: 'submit'}).then(function(token) {
                // Add your logic to submit to your backend server here.
            });
        });
    }
</script>
<br><br><br><br><br>
<?php
include __DIR__ . "/footer.php";

?>

