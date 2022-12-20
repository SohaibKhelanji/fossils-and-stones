<?php

include 'incs/header.php';
include 'classes/dbh.php';

if (isset($_SESSION['userId']) && $userRole == "user") {
    header("Location: 404.php");
}elseif(!isset($_SESSION['userId'])){
    header("Location: 404.php");
}

$dbh = new Dbh();

$productId = $_GET['id'];

$stmt = $dbh->connection()->prepare("SELECT * FROM product WHERE product_id = :productId");
$stmt->bindParam(':productId', $productId);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$productName = $row['product_name'];

if ($stmt->rowCount() < 1) {
    header("Location: 404.php");
}

if (isset($_POST['yes'])) {
    $stmt = $dbh->connection()->prepare("DELETE FROM product WHERE product_id = :productId");
    $stmt->bindParam(':productId', $productId);
    $stmt->execute();
    header("Location: products.php");

}elseif(isset($_POST['no'])){
    header("Location: products.php");
}

?>

<?php
include 'incs/navBar.php';
?>

<body>

<div id="delete-category-message">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center"><?php echo $productName?> Verwijderen?</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form action="deleteProduct.php?id=<?php echo $productId; ?>" method="POST">
                <p>Weet u zeker dat u dit product wilt verwijderen?</p>
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