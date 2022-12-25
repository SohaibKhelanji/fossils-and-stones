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
    header("Location: 404.php");
}


if (isset($_POST['yes'])) {
    $stmt = $dbh->connection()->prepare("DELETE FROM product_category WHERE category_id = :categoryId");
    $stmt->bindParam(':categoryId', $categoryId);
    $stmt->execute();
    header("Location: categories.php");
} elseif (isset($_POST['no'])) {
    header("Location: categories.php");
}

?>

<?php
include 'incs/navBar.php';
?>

<body>

    <div id="delete-category-message">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center"><?php echo $categoryName ?> Verwijderen?</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form action="deleteCategory.php?id=<?php echo $categoryId; ?>" method="POST">
                    <p>Weet u zeker dat u deze categorie wilt verwijderen?</p>
                    <br>
                    <button type="submit" name="yes" class="message-button-confirm">Bevestigen</button>
                    <button type="submit" name="no" class="message-button-cancel">Anuleren</button>
                </form>
            </div>
        </div>
    </div>



    <?php
    include 'incs/footer.php';
    ?>