<?php
session_start();
if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
}
include '../classes/dbh.php';

$dbh = new Dbh();

if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $stmt = $dbh->connection()->prepare("SELECT * FROM order_product INNER JOIN product ON product.product_id = order_product.product_id INNER JOIN product_image ON product_image.product_id = product.product_id INNER JOIN orders ON orders.orders_id = order_product.orders_id WHERE orders.user_id = $userId AND product_name LIKE '%$search%' OR product_description LIKE '%$search%' or orders.orders_id LIKE '%$search%' ORDER BY product_name DESC;");
    $stmt->execute();
    $result = $stmt->fetchAll();
    echo "<h2 class=\"search-title\">Zoekresultaten voor: <span>$search</span></h2>";
    foreach ($result as $product) {
        echo "
        <div class=\"user-card\" onclick=\"window.location.href='viewOrder.php?id=$product[orders_id]';\" >
        <img src=\"imgs/$product[image_name]\" alt=\"product image\">
        <h2>$product[product_name]</h2>
        <p style=\"font-size:20px\">bestelnmr. #$product[orders_id]</p>
        </div>
        <br>
        ";
    }
}
