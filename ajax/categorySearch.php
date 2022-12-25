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
    $stmt = $dbh->connection()->prepare("SELECT * FROM product_category WHERE category_name LIKE '%$search%'");
    $stmt->execute();
    $result = $stmt->fetchAll();
    echo "<h2 class=\"search-title\">Zoekresultaten voor: <span>$search</span></h2>";
    echo "<div id=\"categories-wrapper\">";
    if ($result) {
        foreach ($result as $row) {
            echo "
            <div class=\"category\">
            <p>$row[category_name]</p>
            <a href=\"editCategory.php?id=$row[category_id]\" style=\"background-color:orange\">Bewerken</a>
            <a href=\"deleteCategory.php?id=$row[category_id]\" style=\"background-color:darkred\">Verwijderen</a>
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
