<?php 
session_start();
if (isset($_SESSION['userId'])) {
    $userRole = $_SESSION['userRole'];

    if (isset($_SESSION['userId']) && $userRole == "user") {
        header("Location: 404.php");
    }elseif(!isset($_SESSION['userId'])){
        header("Location: 404.php");
    }
}else{
    header("Location: 404.php");
}

include '../classes/dbh.php';

$dbh = new Dbh();

if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $stmt = $dbh->connection()->prepare("SELECT * FROM user WHERE user_firstname LIKE '%$search%' OR user_lastname LIKE '%$search%' OR user_email LIKE '%$search%'");
    $stmt->execute();
    $result = $stmt->fetchAll();
    echo "<h2 class=\"search-title\">Zoekresultaten voor: <span>$search</span></h2>";
    echo "<div id=\"users-container\">";
    if ($result) {
        foreach ($result as $row) {
            echo "
            <div class=\"user-card\" onclick=\"window.location.href='viewUserAdmin.php?id=$row[user_id]';\" >
            <h2>$row[user_firstname] $row[user_lastname]</h2>
            <p>$row[user_email]</p>
            <p>$row[user_role]</p>
            </div>
            ";
        }
        echo "</div>";
    } else {
        echo "
        <div id=\"no-results\">
            <h2>Geen resultaten gevonden</h2>
            <p>Probeer het opnieuw met een andere zoekterm</p>
        </div>
            ";
    }
}
?>