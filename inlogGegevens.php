<?php include __DIR__ . "/header.php";
include __DIR__ . "/connect.php";
?>

<div class="container">
    <div class="row">
            <h2>Inlog gegevens aanpassen</h2>
            <form action="updateWachtwoord.php" method="post">
                <div class="form-group row">
                    <label for="Tussenvoegsel" class="col-sm-2 labelInput">Oude wachtwoord</label>
                    <div class="col-sm-10 klantGegevensInputWrap">
                        <input type="password" class="form-control-plaintext klantGegevensInput" id="password01" name="oldPassword" required><i class="fas fa-eye iconWW" id="togglePassword01"></i>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="Tussenvoegsel" class="col-sm-2 labelInput">Nieuwe wachtwoord</label>
                    <div class="col-sm-10 klantGegevensInputWrap">
                        <input type="password" class="form-control-plaintext klantGegevensInput" id="password02" name="newPassword" required><i class="fas fa-eye iconWW" id="togglePassword02"></i>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="Tussenvoegsel" class="col-sm-2 labelInput">Nieuwe wachtwoord bevestigen</label>
                    <div class="col-sm-10 klantGegevensInputWrap">
                        <input type="password" class="form-control-plaintext klantGegevensInput" id="password03" name="newPasswordConfirm" required><i class="fas fa-eye iconWW" id="togglePassword03"></i>
                    </div>
                </div>

                <input type="submit" name="submit" class="btn btn-primary" style="width: 250px; float: right" value="Sla je nieuwe wachtwoord op">
            </form>
    </div>
</div>

<script>
    const togglePassword01 = document.querySelector('#togglePassword01');
    const password01 = document.querySelector('#password01');

    togglePassword01.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = password01.getAttribute('type') === 'password' ? 'text' : 'password';
        password01.setAttribute('type', type);
        // toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
    });

    const togglePassword02 = document.querySelector('#togglePassword02');
    const password02 = document.querySelector('#password02');

    togglePassword02.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = password02.getAttribute('type') === 'password' ? 'text' : 'password';
        password02.setAttribute('type', type);
        // toggle the eye slash icon
        this.classList.toggle('fas-eye-slash');
    });

    const togglePassword03 = document.querySelector('#togglePassword03');
    const password03 = document.querySelector('#password03');

    togglePassword03.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = password03.getAttribute('type') === 'password' ? 'text' : 'password';
        password03.setAttribute('type', type);
        // toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
    });
</script>