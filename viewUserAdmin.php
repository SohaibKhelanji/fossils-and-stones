<?php

include 'incs/header.php';
include 'classes/dbh.php';

if (isset($_SESSION['userId']) && $userRole == "user") {
    header("Location: 404.php");
}elseif(!isset($_SESSION['userId'])){
    header("Location: 404.php");
}

$dbh = new Dbh();

$viewUserId = $_GET['id'];
?>

<body>

<?php 
include 'incs/navBar.php';
?>

<div id="view-user-container">
<?php

// get user via id and adress info via user id and show it in a table

$stmt = $dbh->connection()->prepare('SELECT * FROM user INNER JOIN user_address ON user.user_id = user_address.user_id WHERE user.user_id= :viewUserId;');
$stmt->bindParam(':viewUserId', $viewUserId);
$stmt->execute();
$user = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($user as $user) {
    $databaseId = $user['user_id'];
    $Firstname = $user['user_firstname'];
    $Lastname = $user['user_lastname'];
    $Email = $user['user_email'];
    $Role = $user['user_role'];
    $Street = $user['address_streetname'];
    $Number = $user['address_housenumber'];
    $PostalCode = $user['address_postalcode'];
    $City = $user['address_city'];

    //    echo all user info in disabled inputs

    echo "
    <form class=\"login-form\" action=\"\">
    <div class=\"form-control\">
                <input type=\"text\" value=\"$Firstname\" disabled>
                <i class=\"fas fa-id-card\"></i>
            </div>
            <div class=\"form-control\">
                <input type=\"text\" value=\"$Lastname\" disabled>
                <i class=\"fas fa-id-card\"></i>
            </div>
            <div class=\"form-control\">
                <input type=\"text\" value=\"$Email\" disabled>
                <i class=\"fas fa-at\"></i>
            </div>
            <div class=\"form-control\">
                <input type=\"text\" value=\"$Role\" disabled>
                <i class=\"fas fa-user-tag\"></i>
            </div>
            <div class=\"form-control\">
                <input type=\"text\" value=\"$Street\" disabled>
                <i class=\"fas fa-road\"></i>
            </div>
            <div class=\"form-control\">
                <input type=\"text\" value=\"$Number\" disabled>
                <i class=\"fas fa-home\"></i>
            </div>
            <div class=\"form-control\">
                <input type=\"text\" value=\"$PostalCode\" disabled>
                <i class=\"fas fa-map-marker-alt\"></i>
            </div>
            <div class=\"form-control\">
                <input type=\"text\" value=\"$City\" disabled>
                <i class=\"fas fa-city\"></i>
            </div>
    </form>

    ";
}
?>


</div>

<?php
include 'incs/footer.php';
?>