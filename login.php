<?php

include 'incs/header.php';

if (isset($_SESSION['userId'])) {
    header("location: 404.php");
    exit();
}

include_once 'classes/dbh.php';
include_once 'classes/user.php';


// set a csrf token 
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(64));
}   



$sessionToken = $_SESSION['csrf_token'];

// check when the user was last active if it was more than 15 minutes ago, unset the csrf token
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) {
    unset($_SESSION['csrf_token']);
    unset($_SESSION['LAST_ACTIVITY']);
}



// update last activity time stamp 

$_SESSION['LAST_ACTIVITY'] = time();





if (isset($_POST['submit'])) {

//   if csrf token is not set, redirect to login page
    if (!isset($_SESSION['csrf_token'])) {
        header('location: login.php?error=csrfTokenInvalidSet');
        die();
    }

//  check if csrf token is valid
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        header('location: login.php?error=csrfTokenInvalid');
        unset($_SESSION['csrf_token']);
        die();
    }

    $firstname = null;
    $lastname = null;
    $email = $_POST['email'];
    $streetname = null;
    $housenumber = null;
    $postalcode = null;
    $city = null;
    $password = $_POST['password'];

    $user = new User($firstname, $lastname, $email, $streetname, $housenumber, $postalcode, $city, $password);
    $user->loginUser();
    unset($_SESSION['csrf_token']);
    header('location: index.php?error=none');
}

?>

<body>
    <?php
    include 'incs/navBar.php';
    ?>
    <br>

    <div class="login-wrapper">
        <section class="side-login">
            <img src="imgs/login.svg" alt="">
        </section>

        <section class="main-login">
            <div class="login-container">
                <p class="title">Welkom terug!</p>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "none") {
                        echo "<p class=\"error-message\" style='color:#7FB319;'>Account is sucsessvol ingelogd!</p>";
                    } else if ($_GET["error"] == "loginUserStmt1Failed") {
                        echo "<p class=\"error-message\" style='color:red'>oeps er is een onverwachte fout opgetreden, probeer het later opnieuw.</p>";
                    } else if ($_GET["error"] == "loginUserStmt2Failed") {
                        echo "<p class=\"error-message\" style='color:red'>oeps er is een onverwachte fout opgetreden, probeer het opnieuw.</p>";
                    } else if ($_GET["error"] == "loginUserStmt3Failed") {
                        echo "<p class=\"error-message\" style='color:red'>oeps er is een onverwachte fout opgetreden, probeer het opnieuw.</p>";
                    } else if ($_GET["error"] == "userNotFound") {
                        echo "<p class=\"error-message\" style='color:red'>Er is geen account gevonden met het ingevoerde e-mailadres. Probeer het alstublieft nog een keer.</p>";
                    } else if ($_GET["error"] == "wrongLoginCredentials") {
                        echo "<p class=\"error-message\" style='color:red'>Het ingevoerde e-mailadres of wachtwoord is onjuist. Probeer het alstublieft nog een keer.</p>";
                    }
                    elseif ($_GET["error"] == "csrfTokenInvalid") {
                        echo "<p class=\"error-message\" style='color:red'>Sessie is verlopen, probeer het opnieuw.</p>";
                    }
                }
                ?>
                <div class="separator"></div>
                <p class="welcome-message">Geef uw inloggegevens op om door te gaan en toegang te krijgen tot al onze diensten</p>

                <form class="login-form" method="post" action="">
                    <div class="form-control">
                        <input type="email" name="email" placeholder="E-mail">
                        <i class="fas fa-at"></i>
                    </div>
                    <div class="form-control">
                        <input type="password" name="password" placeholder="Wachtwoord">
                        <i class="fas fa-lock"></i>
                    </div>

                    <input type="hidden" name="csrf_token" value="<?php echo $sessionToken; ?>">

                    <button class="submit" type="submit" name="submit">Login</button>
                </form>

                <a href="register.php" class="register-login-text">Heeft u nog geen account? <span>Registreer hier!</span></a>
            </div>
        </section>
    </div>
</body>

<?php
include 'incs/footer.php';
?>