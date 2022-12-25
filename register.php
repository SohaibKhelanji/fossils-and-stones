<?php

include 'incs/header.php';

if (isset($_SESSION['userId'])) {
    header("location: 404.php");
    exit();
}

include_once 'classes/dbh.php';
include_once 'classes/user.php';

if (isset($_POST['submit'])) {

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $streetname = $_POST['streetname'];
    $housenumber = $_POST['housenumber'];
    $postalcode = $_POST['postalcode'];
    $city = $_POST['city'];
    $password = $_POST['password'];

    $user = new User($firstname, $lastname, $email,  $streetname, $housenumber, $postalcode, $city, $password);
    $user->createUser();
}
?>

<body>
    <?php
    include 'incs/navBar.php';
    ?>
    <br>

    <div class="login-wrapper">
        <section class="side-login">
            <img src="imgs/register.svg" alt="">
        </section>

        <section class="main-login">
            <div class="login-container">
                <p class="title">Welkom!</p>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "none") {
                        echo "<p class=\"error-message\" style='color:#7FB319;'>Account is sucsessvol geregistreerd!</p>";
                    } else if ($_GET["error"] == "stmtUserExistsFailed") {
                        echo "<p class=\"error-message\" style='color:red'>E-mail is al in gebruik! Login in of probeer een andere E-mail.</p>";
                    } else if ($_GET["error"] == "stmtCreateUserFailed") {
                        echo "<p class=\"error-message\" style='color:red'>oeps er is een onverwachte fout opgetreden, probeer het later opnieuw.</p>";
                    } else if ($_GET["error"] == "stmt2CreateUserFailed") {
                        echo "<p class=\"error-message\" style='color:red'>oeps er is een onverwachte fout opgetreden, probeer het opnieuw.</p>";
                    } else if ($_GET["error"] == "stmt3CreateUserFailed") {
                        echo "<p class=\"error-message\" style='color:red'>oeps er is een onverwachte fout opgetreden, probeer het opnieuw.</p>";
                    }
                }
                ?>
                <div class="separator"></div>
                <p class="welcome-message">Geef uw gegevens op om te registreren en toegang te krijgen tot al onze diensten.</p>

                <form class="login-form" method="post" action="">
                    <div class="form-control">
                        <input type="text" name="firstname" placeholder="Voornaam">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <div class="form-control">
                        <input type="text" name="lastname" placeholder="Achternaam">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <div class="form-control">
                        <input type="text" name="email" placeholder="E-mail">
                        <i class="fas fa-at"></i>
                    </div>
                    <div class="form-control">
                        <input type="text" name="streetname" placeholder="Straatnaam">
                        <i class="fas fa-road"></i>
                    </div>
                    <div class="form-control">
                        <input type="text" name="housenumber" placeholder="Huisnummer">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="form-control">
                        <input type="text" name="postalcode" placeholder="Postcode">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="form-control">
                        <input type="text" name="city" placeholder="Stad">
                        <i class="fas fa-city"></i>
                    </div>
                    <div class="form-control">
                        <input type="password" name="password" placeholder="Wachtwoord">
                        <i class="fas fa-lock"></i>
                    </div>

                    <p class="info-text">Door op "Registreren" te klikken, gaat u akkoord met onze <a href="#">algemene voorwaarden</a> en <a href="#">privacybeleid</a>.</p>

                    <button class="submit" type="sumbit" name="submit">Registreren</button>
                </form>

                <a href=login.php class="register-login-text">Heeft u al een account? <span>Log hier in!</span></a>
            </div>
        </section>
    </div>
</body>

<?php
include 'incs/footer.php';
?>