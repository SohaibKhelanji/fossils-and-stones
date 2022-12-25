<?php

include 'incs/header.php';
include 'classes/dbh.php';

if (!isset($_SESSION['userId'])) {
    header("Location: 404.php");
}

$dbh = new Dbh();

// if is submit button pressed update user info

if (isset($_POST['submit'])) {
    $userFirstname = $_POST['userFirstname'];
    $userLastname = $_POST['userLastname'];
    $userEmail = $_POST['userEmail'];
    $userStreetName = $_POST['userStreetName'];
    $userHouseNumber = $_POST['userHouseNumber'];
    $userPostalCode = $_POST['userPostalCode'];
    $userCity = $_POST['userCity'];


    $stmt = $dbh->connection()->prepare("UPDATE user INNER JOIN user_address ON user.user_id = user_address.user_id SET user_firstname = :userFirstname, user_lastname = :userLastname, user_email = :userEmail, address_streetname = :userStreetName, address_housenumber = :userHouseNumber, address_postalcode = :userPostalCode, address_city = :userCity WHERE user.user_id = $userId");
    $stmt->bindParam(':userFirstname', $userFirstname);
    $stmt->bindParam(':userLastname', $userLastname);
    $stmt->bindParam(':userEmail', $userEmail);
    $stmt->bindParam(':userStreetName', $userStreetName);
    $stmt->bindParam(':userHouseNumber', $userHouseNumber);
    $stmt->bindParam(':userPostalCode', $userPostalCode);
    $stmt->bindParam(':userCity', $userCity);
    $stmt->execute();

    header("Location: logout.php");
}

?>

<?php
include 'incs/navbar.php';

?>


<h1 style="text-align:center;">Profiel</h1>

<div id="view-user-container">
    <form class="login-form" action="" method="post">
        <div class="form-control">
            <input type="text" name="userFirstname" value="<?php echo $userFirstname ?>">
            <i class="fas fa-id-card"></i>
        </div>
        <div class="form-control">
            <input type="text" name="userLastname" value="<?php echo $userLastname ?>">
            <i class="fas fa-id-card"></i>
        </div>
        <div class="form-control">
            <input type="text" name="userEmail" value="<?php echo $userEmail ?>">
            <i class="fas fa-at"></i>
        </div>
        <div class="form-control">
            <input type="text" name="userStreetName" value="<?php echo $userStreetName ?>">
            <i class="fas fa-road"></i>
        </div>
        <div class="form-control">
            <input type="text" name="userHouseNumber" value="<?php echo $userHouseNumber ?>">
            <i class="fas fa-home"></i>
        </div>
        <div class="form-control">
            <input type="text" name="userPostalCode" value="<?php echo $userPostalCode ?>">
            <i class="fas fa-map-marker-alt"></i>
        </div>
        <div class="form-control">
            <input type="text" name="userCity" value="<?php echo $userCity ?>">
            <i class="fas fa-city"></i>
        </div>
        <button name="submit" type="submit" id="submit" class="submit-profile">Bewerken</button>
    </form>
</div>

<?php

include 'incs/footer.php';

?>