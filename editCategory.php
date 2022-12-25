<?php

include 'incs/header.php';
include 'classes/dbh.php';

if (isset($_SESSION['userId']) && $userRole == "user") {
    header("Location: 404.php");
} elseif (!isset($_SESSION['userId'])) {
    header("Location: 404.php");
}

$dbh = new Dbh();

$categoryId = $_GET['id'];


$stmt = $dbh->connection()->prepare("SELECT * FROM product_category WHERE category_id = :categoryId");
$stmt->bindParam(':categoryId', $categoryId);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$categoryName = $row['category_name'];


if ($stmt->rowCount() < 1) {
    header("Location: 400.php");
}

?>

<body>

    <?php
    include 'incs/navBar.php';
    ?>


    <div id="add-category-container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center"><?php echo $categoryName ?> bewerken</h1>
            </div>
        </div>
        <form class="login-form" method="post" action="">
            <div class="form-control">
                <input type="text" name="categoryName" id="categoryName" placeholder="Naam categorie" value="<?php echo $categoryName; ?>" required>
                <i class="fas fa-font"></i>
            </div>
            <button class="submit" type="submit" name="submit">Bewerken</button>
        </form>
    </div>



    <?php
    if (isset($_POST['submit'])) {
        $categoryName = $_POST['categoryName'];
        $stmt = $dbh->connection()->prepare("UPDATE product_category SET category_name = :categoryName WHERE category_id = :categoryId");
        $stmt->bindParam(':categoryName', $categoryName);
        $stmt->bindParam(':categoryId', $categoryId);
        $stmt->execute();
        header("Location: categories.php");
    }
    ?>

    <?php
    include 'incs/footer.php';
    ?>