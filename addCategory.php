<?php

include 'incs/header.php';
include 'classes/dbh.php';

if (isset($_SESSION['userId']) && $userRole == "user") {
    header("Location: 404.php");
} elseif (!isset($_SESSION['userId'])) {
    header("Location: 404.php");
}

$dbh = new Dbh();
?>

<body>

    <?php
    include 'incs/navBar.php';
    ?>

    <div id="add-category-container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Categorie toevoegen</h1>
            </div>
        </div>
        <form class="login-form" method="post" action="">
            <div class="form-control">
                <input type="text" name="categoryName" id="categoryName" placeholder="Naam categorie" required>
                <i class="fas fa-font"></i>
            </div>
            <button class="submit" type="submit" name="submit">Toevoegen</button>
        </form>
    </div>



    <?php
    if (isset($_POST['submit'])) {
        $categoryName = $_POST['categoryName'];
        $stmt = $dbh->connection()->prepare("INSERT INTO product_category (category_name) VALUES (:categoryName)");
        $stmt->bindParam(':categoryName', $categoryName);
        $stmt->execute();
        header("Location: categories.php");
    }
    ?>

    <?php
    include 'incs/footer.php';
    ?>