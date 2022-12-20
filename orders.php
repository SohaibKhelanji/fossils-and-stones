<?php

include 'incs/header.php';
include 'classes/dbh.php';

if (!isset($_SESSION['userId'])) {
    header("Location: 404.php");
}

$dbh = new Dbh();
?>

<body>

<?php 
include 'incs/navBar.php';
?>

<form class="search-bar" methode="post" action="">
    <input id="searchOrder" class="input-search" type="text" name="searchOrder" placeholder="Zoek een bestelling">
    <button type="submit" name="submit-search"><i class="fas fa-search"></i></button>
</form>

<div id="search-results-orders"></div>

<div id="all-orders">

<?php


$stmtCategory = $dbh->connection()->prepare("SELECT * FROM orders where user_id = $userId ORDER BY orders_timestamp DESC");
$stmtCategory->execute();
$resultCategory = $stmtCategory->fetchAll();

foreach ($resultCategory as $category) {

    $orderTimestamp = date("d-m-Y H:i", strtotime($category['orders_timestamp']));
    $orderTimestamp = date("l j F Y H:i", strtotime($orderTimestamp));

    $orderTimestamp = str_replace("January", "Januari", $orderTimestamp);
    $orderTimestamp = str_replace("February", "Februari", $orderTimestamp);
    $orderTimestamp = str_replace("March", "Maart", $orderTimestamp);
    $orderTimestamp = str_replace("April", "April", $orderTimestamp);
    $orderTimestamp = str_replace("May", "Mei", $orderTimestamp);
    $orderTimestamp = str_replace("June", "Juni", $orderTimestamp);
    $orderTimestamp = str_replace("July", "Juli", $orderTimestamp);
    $orderTimestamp = str_replace("August", "Augustus", $orderTimestamp);
    $orderTimestamp = str_replace("September", "September", $orderTimestamp);
    $orderTimestamp = str_replace("October", "Oktober", $orderTimestamp);
    $orderTimestamp = str_replace("November", "November", $orderTimestamp);
    $orderTimestamp = str_replace("December", "December", $orderTimestamp);

    $orderTimestamp = str_replace("Monday", "Maandag", $orderTimestamp);
    $orderTimestamp = str_replace("Tuesday", "Dinsdag", $orderTimestamp);
    $orderTimestamp = str_replace("Wednesday", "Woensdag", $orderTimestamp);
    $orderTimestamp = str_replace("Thursday", "Donderdag", $orderTimestamp);
    $orderTimestamp = str_replace("Friday", "Vrijdag", $orderTimestamp);
    $orderTimestamp = str_replace("Saturday", "Zaterdag", $orderTimestamp);
    $orderTimestamp = str_replace("Sunday", "Zondag", $orderTimestamp);





    echo "<div class=\"products-wrapper-category\">";
    echo "
        <h2 class=\"category-title\"> $orderTimestamp</h2>
        ";

    

    $stmt = $dbh->connection()->prepare("SELECT * FROM order_product INNER JOIN product ON product.product_id = order_product.product_id INNER JOIN product_image ON product_image.product_id = product.product_id INNER JOIN orders ON orders.orders_id = order_product.orders_id WHERE orders.orders_id = $category[orders_id] and orders.user_id = $userId ORDER BY orders.orders_timestamp;");

    $stmt->execute();

    $result = $stmt->fetchAll();

    foreach ($result as $product) {
        echo "
        <div class=\"user-card\" onclick=\"window.location.href='viewOrder.php?id=$category[orders_id]';\" >
        <img src=\"imgs/$product[image_name]\" alt=\"product image\">
        <h2>$product[product_name]</h2>
        <p style=\"font-size:20px\">€$product[product_price]</p>
        </div>
        <br>
        ";
    }
    echo "</div>";
}



?>

</div>

<?php
include 'incs/footer.php';
?>
